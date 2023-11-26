const express = require("express");
const app = express();
const mysql = require("mysql2/promise");
const bcrypt = require("bcrypt");
require("dotenv").config();
const generateAccessToken = require("./generateAccessToken");

async function initialize() {
    try {
        const db = await mysql.createPool({
            connectionLimit: 100,
            host: process.env.DB_HOST,
            user: process.env.DB_USER,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_DATABASE,
            port: process.env.DB_PORT,
        });

        const port = process.env.PORT || 4000;
        app.listen(port, () => console.log(`Server Started on port ${port}...`));

        app.use(express.json());

        app.post("/createUser", async (req, res) => {
            const user = req.body.name;
            const hashedPassword = await bcrypt.hash(req.body.password, 10);

            const connection = await db.getConnection();
            try {
                const sqlSearch = "SELECT * FROM user WHERE user = ?";
                const search_query = mysql.format(sqlSearch, [user]);

                const sqlInsert = "INSERT INTO user VALUES (0,?,?)";
                const insert_query = mysql.format(sqlInsert, [user, hashedPassword]);

                const [result] = await connection.query(search_query);

                console.log("------> Search Results");
                console.log(result.length);

                if (result.length !== 0) {
                    console.log("------> User already exists");
                    return res.status(409).send("User already exists");
                } else {
                    await connection.query(insert_query);
                    console.log("--------> Created new User");
                    return res.sendStatus(201);
                }
            } catch (error) {
                console.error(error);
                return res.status(500).send("Internal Server Error");
            } finally {
                connection.release();
            }
        });

        app.post("/login", async (req, res) => {
            const user = req.body.name;
            const password = req.body.password;

            const connection = await db.getConnection();
            try {
                const sqlSearch = "SELECT * FROM user WHERE user = ?";
                const search_query = mysql.format(sqlSearch, [user]);

                const [result] = await connection.query(search_query);

                console.log("------> Search Results");
                console.log(result.length);

                if (result.length === 0) {
                    console.log("--------> User does not exist");
                    return res.sendStatus(404);
                }

                const hashedPassword = result[0].password;

                if (await bcrypt.compare(password, hashedPassword)) {
                    console.log("---------> Login Successful");
                    console.log("---------> Generating accessToken");
                    const token = generateAccessToken({ user: user });
                    console.log(token);
                    return res.json({ accessToken: token });
                } else {
                    return res.send("Password incorrect!");
                }
            } catch (error) {
                console.error(error);
                return res.status(500).send("Internal Server Error");
            } finally {
                connection.release();
            }
        });
    } catch (error) {
        console.error("Failed to initialize:", error);
    }
}

initialize();
