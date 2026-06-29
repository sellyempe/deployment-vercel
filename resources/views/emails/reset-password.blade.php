<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Atur Ulang Kata Sandi</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 40px; color: #333333;">
    <div
        style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 16px; border: 1px solid #e4e4e7; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h2
            style="color: #db2777; margin-top: 0; font-size: 24px; font-weight: bold; border-bottom: 2px solid #fbcfe8; padding-bottom: 15px; margin-bottom: 25px;">
            Atur Ulang Kata Sandi
        </h2>
        <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Halo,</p>
        <p style="font-size: 16px; line-height: 1.6; margin-bottom: 25px;">
            Anda menerima email ini karena kami menerima permintaan atur ulang kata sandi untuk akun Anda.
        </p>
        <div style="margin: 35px 0; text-align: center;">
            <a href="{{ $url }}"
                style="background-color: #db2777; color: #ffffff; padding: 14px 28px; border-radius: 10px; text-decoration: none; font-weight: bold; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px -1px rgba(219,39,119,0.2);">
                Atur Ulang Kata Sandi
            </a>
        </div>
        <p style="font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 10px;">
            Tautan reset kata sandi ini akan kedaluwarsa dalam 15 menit.
        </p>
        <p style="font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 30px;">
            Jika Anda tidak meminta atur ulang kata sandi, Anda dapat mengabaikan email ini dengan aman.
        </p>
        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 30px 0;">
        <p style="font-size: 12px; line-height: 1.5; color: #6b7280; margin-bottom: 10px;">
            Jika Anda mengalami kendala saat mengeklik tombol "Atur Ulang Kata Sandi", salin dan tempel tautan di bawah
            ini ke browser Anda:
        </p>
        <p style="font-size: 12px; color: #db2777; word-break: break-all; margin-bottom: 30px;">
            <a href="{{ $url }}" style="color: #db2777; text-decoration: underline;">{{ $url }}</a>
        </p>
        <p style="font-size: 15px; line-height: 1.6; margin-top: 25px; color: #1f2937;">
            Salam Hangat,<br>
            <strong>Pink Tour and Travel</strong>
        </p>
    </div>
</body>

</html>