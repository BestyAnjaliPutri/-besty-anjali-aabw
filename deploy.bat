@echo off
title Deploy to GitHub and Vercel
color 0D
echo ========================================================
echo   [SIA-AKN] Upload Perubahan ke GitHub & Deploy Vercel
echo ========================================================
echo.

cd /d "%~dp0"

echo [1/3] Menambahkan file yang diubah (git add .)...
git add .

echo [2/3] Menyimpan commit...
git commit -m "Update: Logo baru, Sakura Login, 3D Zero Two, dan perbaikan Buku Besar"

echo [3/3] Mengupload ke GitHub (git push origin main)...
git push origin main

echo.
echo ========================================================
echo   BERHASIL! Commit telah ter-upload ke GitHub.
echo   Vercel akan otomatis melakukan build dan deploy
echo   dalam kurun waktu 15 - 30 detik.
echo ========================================================
echo.
pause
