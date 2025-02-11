<?php
include 'dbController.php';

// Fungsi normalisasi untuk metode SAW
function normalisasiSAW($matrix, $tipe_kriteria) {
    $norm_matrix = [];
    foreach ($matrix as $j => $col) {
        $max = max(array_column($matrix, $j));
        $min = min(array_column($matrix, $j));
        foreach ($col as $i => $val) {
            $norm_matrix[$i][$j] = ($tipe_kriteria[$j] == 'benefit') ? ($val / $max) : ($min / $val);
        }
    }
    return $norm_matrix;
}

// Fungsi untuk perhitungan SAW
function hitungSAW($matrix, $bobot, $tipe_kriteria) {
    $norm_matrix = normalisasiSAW($matrix, $tipe_kriteria);
    $hasil = [];
    foreach ($norm_matrix as $i => $row) {
        $hasil[$i] = array_sum(array_map(function($val, $bobot) {
            return $val * $bobot;
        }, $row, $bobot));
    }
    return $hasil;
}

// Fungsi untuk perhitungan WP
function hitungWP($matrix, $bobot, $tipe_kriteria) {
    $bobot_ternormalisasi = array_map(function($b) use ($bobot) {
        return $b / array_sum($bobot);
    }, $bobot);
    
    $hasil = [];
    foreach ($matrix as $i => $row) {
        $hasil[$i] = array_product(array_map(function($val, $bobot, $tipe) {
            return pow(($tipe == 'cost') ? (1 / $val) : $val, $bobot);
        }, $row, $bobot_ternormalisasi, $tipe_kriteria));
    }
    
    $total = array_sum($hasil);
    foreach ($hasil as $i => $val) {
        $hasil[$i] = $val / $total;
    }
    return $hasil;
}

// Fungsi untuk perhitungan TOPSIS
function hitungTOPSIS($matrix, $bobot, $tipe_kriteria) {
    $norm_matrix = [];
    foreach ($matrix as $j => $col) {
        $sqrt_sum = sqrt(array_sum(array_map(fn($x) => pow($x, 2), $col)));
        foreach ($col as $i => $val) {
            $norm_matrix[$i][$j] = $val / $sqrt_sum;
        }
    }
    
    $weighted_matrix = [];
    foreach ($norm_matrix as $i => $row) {
        foreach ($row as $j => $val) {
            $weighted_matrix[$i][$j] = $val * $bobot[$j];
        }
    }
    
    $ideal_pos = [];
    $ideal_neg = [];
    foreach ($weighted_matrix[0] as $j => $_) {
        $col = array_column($weighted_matrix, $j);
        $ideal_pos[$j] = ($tipe_kriteria[$j] == 'benefit') ? max($col) : min($col);
        $ideal_neg[$j] = ($tipe_kriteria[$j] == 'benefit') ? min($col) : max($col);
    }
    
    $dist_pos = array_map(fn($row) => sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $row, $ideal_pos))), $weighted_matrix);
    $dist_neg = array_map(fn($row) => sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $row, $ideal_neg))), $weighted_matrix);
    
    return array_map(fn($d_pos, $d_neg) => $d_neg / ($d_pos + $d_neg), $dist_pos, $dist_neg);
}
?>
