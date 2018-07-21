<?php
# getMP3info.php

// ===== Получение информации о mp3-файле ======================================
function getMP3data($filename) {
	$ret = array();
    $ret['filename'] = $filename;
	if (!@$f = fopen($filename, 'rb')) {
		$ret['error'] = 'Error opening file.';
		return $ret;
	}
	// Определение ID3 тегов
	if ($s = getID3v1($filename)) { $ret['id3v1'] = $s; }
	if ($s = getID3v2($filename)) { $ret['id3v2'] = $s; }

	// Если есть id3v2 тег, то перед поиском mp3 фрейма сдвигаем указатель файла за id3v2 тег
	if ($ret['id3v2']['size']) { fseek($f, $ret['id3v2']['size'] + 10); }

	// Ищем mp3 фрейм. - 11111111-11111111-1111111? (0xFFF(E))
	do {
		while (fread($f, 1) != chr(255)) {			if (feof($f)) {				$ret['error'] = 'MP3 frame not found.';
				return $ret;
			}
		}
		$s = fread($f, 3);
		$header = sprintf('%08b%08b%08b%08b', 255, ord($s[0]), ord($s[1]), ord($s[2]));
	} while ($header[0] != 1 && $header[1] != 1 && $header[2] != 1) ;

	// Нашли первый mp3 фрейм. Читаем информацию
	if ($header[11] == 0) {		$ret['id'] == 'MPEG-2.5';
	} else {		if ($header[12] == 1) { $ret['id'] = 'MPEG-1'; } else { $ret['id'] = 'MPEG-2'; }
	}

	$layers = array(
		array(0, 3),
		array(2, 1)
		);

	$ret['layer'] = $layers[$header[13]][$header[14]];

	if ($header[15] == 0) {	$ret['protect_CRC'] = true; }

	$bitrates['MPEG-1'] = array(
		1 => array(0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448),// MPEG-1 Layer I
		2 => array(0, 32, 48, 56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 384),// MPEG-1 Layer II
		3 => array(0, 32, 40, 48,  56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320) // MPEG-1 Layer III
		);
	$bitrates['MPEG-2'] = array(
		1 => array(0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448),// MPEG-2 Layer I
		2 => array(0, 32, 48, 56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 384),// MPEG-2 Layer II
		3 => array(0, 8,  16, 24,  32,  64,  80,  56,  64, 128, 160, 112, 128, 256, 320) // MPEG-2 Layer III
		);
	$bitrates['MPEG-2.5'] = array(
		1 => array(0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0),// MPEG-2.5 Layer I
		2 => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0),// MPEG-2.5 Layer II
		3 => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0) // MPEG-2.5 Layer III
		);

	$ret['bitrate'] = $bitrates[$ret['id']][$ret['layer']][bindec($header[16].$header[17].$header[18].$header[19])];

    $frequency = array(
		'MPEG-1' => array(
			'0' => array(44100, 48000),
			'1' => array(32000, 0),
		),
		'MPEG-2' => array(
			'0' => array(22050, 24000),
			'1' => array(16000, 0),
		),
		'MPEG-2.5' => array(
			'0' => array(11025, 12000),
			'1' => array(8000, 0),
		),
	);
    $ret['frequency'] = $frequency[$ret['id']][$header[20]][$header[21]];
    $ret['padding'] = $header[22];

	$samplesPerFrame = array(
		'MPEG-1' 	=> array(1 => 384, 2 => 1152, 3 => 1152),
		'MPEG-2' 	=> array(1 => 384, 2 => 1152, 3 => 576),
		'MPEG-2.5' 	=> array(1 => 384, 2 => 1152, 3 => 576)
		);

	$modes = array(
		0 => array('Stereo', 'Joint stereo'),
		1 => array('Dual channel', 'Mono')
		);

	$ret['mode'] = $modes[$header[24]][$header[25]];
    // Если режим = Joint Stereo
    if ($header[24] == 0 && $header[25] == 1) {    	$ret['Intensity stereo'] = $header[26];
    	$ret['MS stereo'] = $header[27];
    }

	$ret['Copyrighted'] = $header[28];
	$ret['Original'] = $header[29];

	$emphasises = array(
		0 => array('None', '50/15ms'),
		1 => array('', 'CCITT j.17')
		);

	$ret['Emphasis'] = $emphasises[$header[30]][$header[31]];
// =============================================================================
	if ($ret['Mode'] != 'Mono' && $ret['id'] == 'MPEG-1') { $offset = 32; }
	else if ($ret['Mode'] == 'Mono' && $ret['id'] == 'MPEG-1') { $offset = 17; }
	else if ($ret['Mode'] == 'Mono' && ($ret['id'] == 'MPEG-2' || $ret['id'] == 'MPEG-2.5')) { $offset = 9; }
	else { $offset = 17; }

	fseek($f, $offset, SEEK_CUR);
	$s = fread($f, 38);

	if (substr($s, 0, 4) == 'VBRI') {
		$ret['bitrate_mode'] = 'VBR';
		$ret['VBR_header'] = 'VBRI';
		$numberOfFrames = bindec(sprintf('%08b%08b%08b%08b', ord($s[14]),ord($s[15]),ord($s[16]),ord($s[17])));
    	$ret['nof'] = $numberOfFrames;
    	$duration = floor($numberOfFrames * $samplesPerFrame[$ret['id']][$ret['layer']] / $ret['frequency']);
	} else
	if (substr($s, 0, 4) == 'Xing') {
		$ret['bitrate_mode'] = 'VBR';
		$ret['VBR_header'] = 'Xing';


		$numberOfFrames = bindec(sprintf('%08b%08b%08b%08b', ord($s[8]),ord($s[9]),ord($s[10]),ord($s[11])));
    	$duration = floor($numberOfFrames * $samplesPerFrame[$ret['id']][$ret['layer']] / $ret['frequency']);
	} else {		$ret['bitrate_mode'] = 'CBR';
    	$datasize = filesize($filename);
    	if ($ret['id3v1']) { $datasize -= 128; }
    	if ($ret['id3v2']) { $datasize -= $ret['id3v2']['size'] - 10; }
    	$duration = floor($datasize / ($ret['bitrate'] * 1000) * 8);
	}

	$ret['duration_str'] 		= sprintf('%02d:%02d',floor($duration/60),floor($duration-(floor($duration/60)*60)));
	$ret['duration_str_hour'] 	= sprintf('%02d:%02d:%02d',floor($duration/3600),floor($duration/60),floor($duration -(floor($duration/60)*60)));
	$ret['diration']			= (int)$duration;

	fclose($f);
	return $ret;
}
// ===== Получение информации о ID3v2 тегах ====================================
function getID3v2($filename) {	$ret = array();
	if (!@$f = fopen($filename, 'rb')) {		$ret['error'] = 'Error opening file.';
		return $ret;
	}

	$header = fread($f, 10);
	$header = @unpack("a3signature/c1version_major/c1version_minor/c1flags/Nsize", $header);
	if ($header['signature'] != 'ID3') {	    fclose($f);
		return false;
	}
	$ret['version'] = $header['version_major']. '.' .$header['version_minor'];
	$bsize = sprintf('%032b', $header['size']);
	$ret['size'] = bindec(substr($bsize, 1, 7).substr($bsize, 9, 7).substr($bsize, 17, 7).substr($bsize, 25, 7));

    fclose($f);
	return $ret;
}
// ===== Получение информации о ID3v1 тегах ====================================
function getID3v1($filename) {
	$ret = array();
	$f = fopen($filename, 'rb');
	if (!@$f = fopen($filename, 'rb')) {
		$ret['error'] = 'Error opening file.';
		return $ret;
	}
	fseek($f, -128, SEEK_END);
	$s = fread($f,128);
	if ($s[125] == chr(0) && $s[126] != chr(0)) {
    	// ID3v1.1
    	$format = 'a3tag/a30name/a30artists/a30album/a4year/a28comment/x1/c1track/c1genreno';
	} else {
    	// ID3v1.0
    	$format = 'a3tag/a30name/a30artists/a30album/a4year/a30comment/c1genreno';
	}

	$ret = unpack($format, $s);

	fclose($f);
	if ($ret['tag'] == 'TAG') { return $ret; }
	return false;
}

?>