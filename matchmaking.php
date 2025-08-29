<?php

/**
 * Memisahkan string "nama-job,nama-job" menjadi array.
 * @param string $str
 * @return array
 */
function splitJobCharacters($str) {
   $items = array_map('trim', explode(',', $str));
    return array_values(array_filter($items, fn($v) => $v !== ''));
}

/**
 * Membalikkan string job (posisi ganjil: 1, 3, 5, ...)
 * @param array $arr
 * @return array
 */
function reverseJobCharacters($arr) {
     $result = [];
    foreach ($arr as $item) {
        [$name, $job] = explode('-', $item);
        // BALIKKAN SELURUH string job (bukan sebagian)
        $job = strrev($job);
        $result[] = $name . '-' . $job;
    }
    return $result;
}

/**
 * Mendekripsi setiap huruf job ke huruf sebelumnya (a->z, b->a, dst)
 * @param array $arr
 * @return array
 */
function decryptJobCharacters($arr) {
    $result = [];
    foreach ($arr as $item) {
        [$name, $job] = explode('-', $item);
        $result[] = $name . '-' . decryptString($job);
    }
    return $result;
}

function decryptString($text) {
    $res = '';
    $len = strlen($text);
    for ($i = 0; $i < $len; $i++) {
        $ch = $text[$i];
        if ($ch >= 'a' && $ch <= 'z') {
            $res .= ($ch === 'a') ? 'z' : chr(ord($ch) - 1);
        } else {
            $res .= $ch;
        }
    }
    return $res;
}

/**
 * Mengelompokkan data menjadi array 2 dimensi: [[nama, job], ...]
 * @param array $arr
 * @return array
 */
function makingDreamTeam($arr) {
    $team = [];
    foreach ($arr as $item) {
        $team[] = explode('-', $item);
    }
    return $team;
}

/**
 * Fungsi utama yang menggabungkan semua proses.
 * @param string $str
 * @return string
 */
function startUpMatchMaking($str) {
    $members = splitJobCharacters($str);
    if (count($members) < 3) {
        return "Minimum 3 members in the team";
    }

    $members = reverseJobCharacters($members);
    $members = decryptJobCharacters($members);
    $team = makingDreamTeam($members);

    // Hitung jumlah unik job
    $jobTypes = array_unique(array_column($team, 1));
    return count($jobTypes) >= 3
        ? "Match your Dream Start-Up Team"
        : "The job composition in the team is not suitable";
}

// --- CONTOH PEMANGGILAN ---
echo startUpMatchMaking('idaz-sfmutvi,anggara-sfutqji,fika-sfldbi') . "\n";
// Match your Dream Start-Up Team

echo startUpMatchMaking('eko-sfldbi,fajrin-sfmutvi,abdullah-sfutqji,anggara-sfutqji') . "\n";
// Match your Dream Start-Up Team

echo startUpMatchMaking('abdullah-sfldbi,fajrin-sfmutvi,samir-sfldbi,eko-sfmutvi,basil-sfmutvi') . "\n";
// The job composition in the team is not suitable

echo startUpMatchMaking('samir-sfmutvi,basil-sfutqji,eko-sfmutvi') . "\n";
// The job composition in the team is not suitable

echo startUpMatchMaking('samir-sfmutvi,basil-sfutqji') . "\n";
// Minimum 3 members in the team
