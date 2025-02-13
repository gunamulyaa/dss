<?php
include 'dbController.php';

// Fungsi normalisasi untuk metode SAW
function normalisasi_saw($matrix, $tipe_kriteria) {
    $norm_matrix = [];
    $num_cols = count($matrix[0]);
    
    for ($j = 0; $j < $num_cols; $j++) {
        $column = array_column($matrix, $j);
        $max_val = max($column);
        $min_val = min($column);
        
        foreach ($matrix as $i => $row) {
            if ($tipe_kriteria[$j] == "benefit") {
                $norm_matrix[$i][$j] = $row[$j] / $max_val;
            } else {
                $norm_matrix[$i][$j] = $min_val / $row[$j];
            }
        }
    }
    return $norm_matrix;
}

// Fungsi untuk perhitungan SAW
function hitung_saw($matrix, $bobot, $tipe_kriteria) {
    $norm_matrix = normalisasi_saw($matrix, $tipe_kriteria);
    $hasil = [];
    
    foreach ($norm_matrix as $i => $row) {
        $hasil[$i] = array_sum(array_map(fn($val, $bobot) => $val * $bobot, $row, $bobot));
    }
    
    return $hasil;
}

// Fungsi untuk perhitungan WP
function hitung_wp($matrix, $bobot, $tipe_kriteria) {
    $num_cols = count($matrix[0]);
    
    foreach ($matrix as $i => $row) {
        for ($j = 0; $j < $num_cols; $j++) {
            if ($tipe_kriteria[$j] == "cost") {
                $matrix[$i][$j] = 1 / $row[$j];
            }
        }
    }
    
    $hasil = [];
    foreach ($matrix as $i => $row) {
        $hasil[$i] = array_product(array_map(fn($val, $bobot) => pow($val, $bobot), $row, $bobot));
    }
    
    return $hasil;
}

// Fungsi untuk perhitungan TOPSIS
function hitung_topsis($matrix, $bobot, $tipe_kriteria) {
    $num_cols = count($matrix[0]);
    $num_rows = count($matrix);
    $norm_matrix = [];
    
    for ($j = 0; $j < $num_cols; $j++) {
        $sum_squares = array_sum(array_map(fn($row) => pow($row[$j], 2), $matrix));
        $sqrt_sum = sqrt($sum_squares);
        
        foreach ($matrix as $i => $row) {
            $norm_matrix[$i][$j] = $row[$j] / $sqrt_sum;
        }
    }
    
    $weighted_matrix = [];
    foreach ($norm_matrix as $i => $row) {
        foreach ($row as $j => $val) {
            $weighted_matrix[$i][$j] = $val * $bobot[$j];
        }
    }
    
    $ideal_positif = [];
    $ideal_negatif = [];
    for ($j = 0; $j < $num_cols; $j++) {
        $column = array_column($weighted_matrix, $j);
        $ideal_positif[$j] = ($tipe_kriteria[$j] == "benefit") ? max($column) : min($column);
        $ideal_negatif[$j] = ($tipe_kriteria[$j] == "benefit") ? min($column) : max($column);
    }
    
    $jarak_positif = [];
    $jarak_negatif = [];
    foreach ($weighted_matrix as $i => $row) {
        $jarak_positif[$i] = sqrt(array_sum(array_map(fn($val, $ideal) => pow($val - $ideal, 2), $row, $ideal_positif)));
        $jarak_negatif[$i] = sqrt(array_sum(array_map(fn($val, $ideal) => pow($val - $ideal, 2), $row, $ideal_negatif)));
    }
    
    $hasil = [];
    foreach ($jarak_negatif as $i => $d_neg) {
        $hasil[$i] = $d_neg / ($jarak_positif[$i] + $d_neg);
    }
    
    return $hasil;
}
?>
