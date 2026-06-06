<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "R00t!ML_Flask#2026",
    "heavy_equipment_msc",
    3307
);

if(!$conn){
    die("Koneksi Database Gagal");
}