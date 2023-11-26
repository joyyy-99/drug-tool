const express = require('express');
const mysql = require('mysql2');


const app = express();
app.use(express.json());

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'drug_dispensing_tool'
});
connection.connect((err) => {
    if(err){
        console.log('Error connecting to the database.' , err);
        return;
    }
    console.log('Database connected successfully!');
});
app.listen(3000,()=> console.log('Server running on PORT 3000'));
//adding a new user
app.post('/create',async (req,res) => {
    const { firstname,lastname,gender,emailaddress,} = req.body;
    try{
        connection.query(
            "INSERT INTO users (Firstname,Lastname,Gender,Emailaddress,) VALUES (?,?,?,?)",
            [firstname,lastname,gender,emailaddress,],
            (err,results,fields) => {
                if (err) {
                    console.log('Error while inserting user into the database',err);
                    return res.status(400).send();
                }
                return res
                .status(201)
                .json({ message: 'New user added successfully'});
            }
        );
    } catch (err){
        console.log(err);
        return res.status(500).send();
    }
});
//editing a drug category
app.patch('/update/:id', async (req,res) =>{
    const id = req.params.id;
    const dcategory = req.body.dcategory;
    
    try{
        connection.query(
            'UPDATE categories SET category_name = ? WHERE id = ?',
            [dcategory,id],
            (err,results,fields) => {
                if (err){
                    console.log(err);
                    return res.status(400).send();
                }
                return res
                .status(201)
                .json({ message: 'New user added successfully'});
            }
        );
    } catch (err){
        console.log(err);
        return res.status(500).send();
    }
});

//Deleting a drug
app.delete('/delete/:Tradename',async (req,res) => {
    const Tradename = req.params.Tradename;
    try{
        connection.query(
            "DELETE FROM drugs WHERE Tradename = ?",
            [Tradename],
            (err,results,fields) => {
                if (err) {
                    console.log(err);
                    return res.status(400).send();
                }
                if(results.affectedRows === 0){
                    return res.status(404).json({message: 'No drug with that Name!'})
                }
                return res.status(200).json({message: 'Drug deleted sucessfully!'});
            }
        );
    } catch (err){
        console.log(err);
        return res.status(500).send();
    }
});
        