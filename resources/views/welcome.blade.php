<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Banking System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #111;
            /* Deep black background */
            color: #f4f4f4;
            /* Light gray for text */
        }

        header {
            background-color: #222;
            /* Dark gray for the header */
            display: flex;
            align-items: center; /* Center content vertically */
            justify-content: center;
            padding: 2rem 1rem;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        header img {
            width: 50px; /* Set width of the logo */
            height: auto;
            margin-right: 1rem; /* Space between logo and title */
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 80vh;
            padding: 2rem;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #fff;
            /* White for heading */
        }

        p {
            font-size: 1.2rem;
            color: #bbb;
            /* Soft gray for supporting text */
            margin-bottom: 2rem;
        }

        .buttons {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }

        .buttons a {
            text-decoration: none;
            color: #fff;
            /* White text for buttons */
            background-color: #da0010; 
            /* Primary color for background */
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .buttons a:hover {
            background-color: #e0000c;
            /* Slightly darker shade of primary color on hover */
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        }

        footer {
            background-color: #222;
            /* Dark gray footer */
            color: #bbb;
            /* Light gray text */
            text-align: center;
            padding: 1rem 0;
            font-size: 0.9rem;
            border-top: 2px solid #333;
            /* Subtle border for separation */
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <!-- Logo -->
        <img src="assets/smallLogo.jpg" alt="Universal Banking Logo">
        Universal Banking System
    </header>
    <main>
        <h1>Welcome</h1>
        <p>Experience a secure and innovative platform for all your banking needs.</p>
        <div class="buttons">
            <a href="login">Login</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Universal Banking System. All rights reserved.</p>
    </footer>
</body>

</html>
