<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <style type="text/css">

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        margin: 40px;
        font: 16px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
        word-wrap: break-word;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
    }

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>
<body>

<div id="container">
    <h1>ModeStreet back-end challenge Solution!</h1>

    <div id="body">
        <p>
            The solution contains all the required APIs as to add, edit, delete, view and list/search product(s).
            <br>
            The solution having basic authentication machanism.
        </p>
        <h2>How to configure?</h2>
        <p>
            The configuration is very simple. You just need to follow some steps and all done.
            <br>
            Following are the steps:

            <ul>
                <li>Configure a web server.</li>
                <li>Clone or download and unzip the project inside server root directory or sub-directory.</li>
                <li>Open the file named "env.php", which is in project home directory.</li>
                <li>Set the server url for constant "BASE_URL". Ex. 'http://modestreet-test.in/'</li>
                <li>Set the database informations as:
                    <ul>
                        <li>Database server name "DB_HOSTNAME". Ex. 'localhost'</li>
                        <li>Database name "DB_NAME". Ex. 'script_db'</li>
                        <li>Database username "DB_USERNAME". Ex. 'root'</li>
                        <li>Database password "DB_PASSWORD". Ex. 'pass'</li>
                        <li>To enable database result caching, set "DB_CACHE_ON" to 'TRUE' otherwise 'FALSE'</li>
                    </ul>
                </li>
                <li>Execute the query of file name "ModeStreetChallange.sql" for the specified database.</li>
            </ul>
            All Done! :)
        </p>
        <h2>APIs Information</h2>
        <p>View the instruction page at GitHub.</p>
    </div>
</div>

</body>
</html>
