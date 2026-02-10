<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EVSU | eBook Login</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', Arial, sans-serif;

            /* BACKGROUND IMAGE FROM public/images */
            background-image:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)
                ),
                url("images/evsu.jpg");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            width: 100%;
            max-width: 440px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
            overflow: hidden;
        }

        .login-header {
            background: #6b0f1a;
            color: white;
            padding: 32px 24px;
            text-align: center;
        }

        .login-header img {
            max-width: 140px;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .login-header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .login-header p {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .form-content {
            padding: 32px 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        input:focus {
            outline: none;
            border-color: #6b0f1a;
            box-shadow: 0 0 0 3px rgba(107, 15, 26, 0.15);
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: #6b0f1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .login-btn:hover {
            background: #540c15;
            transform: translateY(-1px);
        }

        .footer {
            text-align: center;
            padding: 18px;
            font-size: 0.8rem;
            color: #6b7280;
            border-top: 1px solid #f3f4f6;
        }

        @media (max-width: 480px) {
            .login-container {
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="login-header">

        <h1>Eastern Visayas State University</h1>
        <p>eBook Management System</p>
    </div>

    <div class="form-content">
        <form action="#" method="POST">

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" placeholder="your.name@evsu.edu.ph" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>
    </div>

    <div class="footer">
        © 2026 Eastern Visayas State University
    </div>

</div>

</body>
</html>
