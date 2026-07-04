<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
</head>
<body style="margin:0; padding:0; background:#f6f7fb; font-family:Arial, sans-serif; color:#1f2937;">
    <div style="max-width:640px; margin:0 auto; padding:24px;">
        <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:24px;">
            <h1 style="margin:0 0 16px; font-size:22px; color:#111827;">New Contact Message</h1>

            <p style="margin:0 0 10px;"><strong>Name:</strong> {{ $contact['name'] }}</p>
            <p style="margin:0 0 10px;"><strong>Email:</strong> {{ $contact['email'] }}</p>
            <p style="margin:0 0 18px;"><strong>Subject:</strong> {{ $contact['subject'] }}</p>

            <div style="padding:16px; background:#f9fafb; border-radius:12px; line-height:1.6;">
                {!! nl2br(e($contact['message'])) !!}
            </div>
        </div>
    </div>
</body>
</html>
