<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: 'Inter', Arial, sans-serif;
        background-image:
            linear-gradient(
                rgba(0, 0, 0, 0.55),
                rgba(0, 0, 0, 0.55)
            ),
            url("/images/evsu.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container,
    .auth-container {
        background: white;
        width: 100%;
        max-width: 440px;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        overflow: hidden;
    }

    .login-header,
    .auth-header {
        background: #6b0f1a;
        color: white;
        padding: 32px 24px;
        text-align: center;
    }

    .login-header h1,
    .auth-header h1 {
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .login-header p,
    .auth-header p {
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

    input[type="email"],
    input[type="password"],
    input[type="text"] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
        outline: none;
        border-color: #6b0f1a;
        box-shadow: 0 0 0 3px rgba(107, 15, 26, 0.15);
    }

    input[type="email"].error,
    input[type="password"].error,
    input[type="text"].error {
        border-color: #dc2626;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .remember-me input[type="checkbox"] {
        width: auto;
        cursor: pointer;
        accent-color: #6b0f1a;
    }

    .remember-me label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .login-btn,
    .auth-btn {
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

    .login-btn:hover:not(:disabled),
    .auth-btn:hover:not(:disabled) {
        background: #540c15;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(107, 15, 26, 0.3);
    }

    .login-btn:disabled,
    .auth-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .auth-link {
        text-align: center;
        margin-top: 16px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .auth-link a {
        color: #6b0f1a;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .auth-link a:hover {
        color: #540c15;
        text-decoration: underline;
    }

    .footer,
    .auth-footer {
        text-align: center;
        padding: 18px;
        font-size: 0.8rem;
        color: #6b7280;
        border-top: 1px solid #f3f4f6;
    }

    /* Loading spinner */
    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 480px) {
        .login-container,
        .auth-container {
            border-radius: 0;
            box-shadow: none;
        }

        .login-header h1,
        .auth-header h1 {
            font-size: 1.4rem;
        }

        .form-content {
            padding: 24px 20px;
        }
    }
</style>