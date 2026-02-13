<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto;">
    <h2>Welcome to the Team, {{ $user->name }}!</h2>
    <p>Your official account has been created. To get started, please click the button below to set your account password.</p>
    
    <div style="margin: 30px 0;">
        <a href="{{ $invitationUrl }}" 
           style="background-color: #4F46E5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Set Up Your Account
        </a>
    </div>

    <p style="color: #666; font-size: 0.8em;">
        This link will expire in 3 days. If the button doesn't work, copy and paste this link into your browser:<br>
        {{ $invitationUrl }}
    </p>
</div>