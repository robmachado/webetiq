<?php

namespace Webetiq\Graphics;

class Grf
{
    
    /*
    public static function Bmp2Grf($filename, $imagename = '')
    {
        $grf = array();
       
        $image = file_get_contents($filename);
        $ini = substr($image, 0, 2);
        if ($ini != 'BM') {
            return false;
        }
        $fw = substr($image, 2, 4);
        $imgw = substr($image, 13, 4);
        
        $l1 = ord(substr($image, 16, 1));
        $l2 = ord(substr($image, 17, 1));
        $n = (($l2 * 256)+$l1) * 256;
        
        $l3 = ord(substr($image, 18, 1));
        $l4 = ord(substr($image, 19, 1));
        $n = ($n + $l4) * 256;
        $width = $n + $l3;
        
        $n = (ord(substr($image, 21, 1)) * 256 + ord(substr($image, 20, 1))) * 256;
        $n = ($n + ord(substr($image, 23, 1))) * 256;
        $high = $n + ord(substr($image, 22, 1));
        
        $n1 = ord(substr($image, 26, 1));
        $n2 = ord(substr($image, 28, 1));
        //if ($n1 != 1 || $n2 != 1) {
        //    echo 'BMP has too many colors, only support monochrome images';
        //    return false;
        //}
        
        $tem = intval($width/8);
        
        if ($width%8 != 0) {
            $tem += 1;
        }
        $bmpl = $tem;
        if ($bmpl%4 != 0) {
            $bmpl += (4 - ($bmpl%4));
            $efg = 1;
        }
        $tot1 = $tem * $high;
        $sTot1 = (string) $tot1;
        $tot = substr($sTot1, 1, strlen($sTot1)-1);
        if (strlen($tot) < 5) {
            $tot = str_pad($tot, 5, "0", STR_PAD_LEFT);
        }
        $sTem = (string) $tem;
        $lon = substr($sTem, 1, strlen($sTem)-1);
        if (strlen($lon) < 3) {
            $lon = str_pad($lon, 3, "0", STR_PAD_LEFT);
        }
        
        $iCount = $high;
        while ($iCount > 1) {
            $a = '';
            $jCount = 1;
            while ($jCount <= $tem) {
                $coun = 62+($iCount-1)*$bmpl+$jCount;
                $l = ord(substr($image, $coun-1, 1));
                if ($jCount == $tem && ($efg == 1 || ($width%8 !=0))) {
                    $base1 = 2 ^ (($tem*8-$width)%8);
                    $l = intval($l/$base1)*$base1+$base1-1;
                }
                $l = -1*$l;
                $a .= substr(dechex($l), 0, 2);
                $jCount++;
            }
            $grf[] = $a;
            $iCount--;
        }
        
   }
   */
   
    /*
    Public Function ConvertBmp2Grf(fileName As String, imageName As String) As Boolean
    Dim TI As String
    Dim i As Short
    Dim WID As Object
    Dim high As Object
    Dim TEM As Short, BMPL As Short, EFG As Short, n2 As String, LON As String
    Dim header_name As String, a As String, j As Short, COUN As Short, BASE1 As Short

    Dim L As String, TOT As String
    Dim N As Object
    Dim TOT1 As Integer
    Dim LL As Byte

    FileOpen(1, fileName, OpenMode.Binary, , , 1)  ' OPEN BMP FILE TO READ
    FileGet(1, LL, 1)
    TI = Convert.ToString(Chr(LL))
    FileGet(1, LL, 2)
    TI += Convert.ToString(Chr(LL))

    If TI <> "BM" Then
        FileClose()
        Return False
    End If

    i = 17
    FileGet(1, LL, i + 1)
    N = LL * 256
    FileGet(1, LL, i)
    N = (N + LL) * 256

    FileGet(1, LL, i + 3)
    N = (N + LL) * 256
    FileGet(1, LL, i + 2)
    N += LL
    WID = N
      
    i = 21
    FileGet(1, LL, i + 1)
    N = LL * 256
    FileGet(1, LL, i)
    N = (N + LL) * 256
    FileGet(1, LL, i + 3)
    N = (N + LL) * 256
    FileGet(1, LL, i + 2)
    N += LL
    high = N
    FileGet(1, LL, 27)
    N = LL
    FileGet(1, LL, 29)

    If N <> 1 Or LL <> 1 Then
        'BMP has too many colors, only support monochrome images
        FileClose(1)
        Return False
    End If

    TEM = Int(WID / 8)
    If (WID Mod 8) <> 0 Then
        TEM += 1
    End If
    BMPL = TEM

    If (BMPL Mod 4) <> 0 Then
        BMPL += (4 - (BMPL Mod 4))
        EFG = 1
    End If

    n2 = fileName.Substring(0, fileName.LastIndexOf("\", StringComparison.Ordinal) + 1) + imageName + ".GRF"

    FileOpen(2, n2, OpenMode.Output) 'OPEN GRF TO OUTPUT
    TOT1 = TEM * high : TOT = Mid(Str(TOT1), 2)
    If Len(TOT) < 5 Then
        TOT = Strings.Left("00000", 5 - Len(TOT)) + TOT
    End If

    LON = Mid(Str(TEM), 2)

    If Len(LON) < 3 Then
        LON = Strings.Left("000", 3 - Len(LON)) + LON
    End If

    header_name = imageName
    PrintLine(2, "~DG" & header_name & "," & TOT & "," & LON & ",")

    For i = high To 1 Step -1
        a = ""
        For j = 1 To TEM
            COUN = 62 + (i - 1) * BMPL + j
            FileGet(1, LL, COUN)
            L = LL

            If j = TEM And (EFG = 1 Or (WID Mod 8) <> 0) Then
                BASE1 = 2 ^ ((TEM * 8 - WID) Mod 8)
                L = Int(L / BASE1) * BASE1 + BASE1 - 1
            End If
            L = Not L
            a += Right(Hex(L), 2)
        Next j
        PrintLine(2, a)
    Next i
    FileClose()

    Return True

End Function
 * 
 */
   

    public static function Bmp2Grf($filename, $outputFileName = 'teste.grf', $invertPixels = false, $withLB = false)
    {
        
        /**
         * vide 
         * https://github.com/asharif/img2grf/blob/master/src/main/java/org/orphanware/App.java
         */

        if (!$fpointer = fopen($filename, "rb")) {
                    return false;
        }
        $file = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($fpointer, 14));
        if ($file['file_type'] != 19778) {
            return false;
        }
        $param = 'Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel/Vcompression/Vsize_bitmap/Vhoriz_resolution/Vvert_resolution/Vcolors_used/Vcolors_important';
        $bmp = unpack($param, fread($fpointer, 40));
        
        $bmp['colors'] = pow(2, $bmp['bits_per_pixel']);
        
        if ($bmp['size_bitmap'] == 0) {
            $bmp['size_bitmap'] = $file['file_size'] - $file['bitmap_offset'];
        }
        fclose($fpointer);
        $bytes = array();
        $fdata = file_get_contents($filename);
        $len = strlen($fdata);
        for ($iCo=0; $iCo<$len; $iCo++) {
            $origBytes[] = ord(substr($fdata, $iCo, 1));
        }
        $bytesLen = count($origBytes);
        echo "height: " . $bmp['height'] . " width: " . $bmp['width'] . " total byte length: " . $bytesLen . "<BR>";
        $pixeloffset = $origBytes[10] + $origBytes[11] + $origBytes[12] + $origBytes[13];
        if ($pixeloffset == 62) {
            echo "pixel offset: " . $pixeloffset . "<BR>";
        } else {
            echo "pixel offset (WARNING! NOT THE DEFAULT OF 62): " . $pixeloffset . "<BR>";
        }
        $newBytes = array();
        $byteW = ceil($bmp['width']/8);
        for ($i = $bytesLen-1; $i >= $pixeloffset; $i--) {
            $tmp = $i - ($byteW-1);
            for ($j = $tmp; $j < $tmp + $byteW; $j++) {
                $newBytes[] = $origBytes[$j];
            }
            $i = $tmp;
        }
        if ($invertPixels) {
            echo "pixels inverted!";
            for ($i = 0; $i < count($newBytes); $i++) {
                $newBytes[$i] ^= 0xFF;
            }
        }
        
        $lineBreakCount = ceil($bmp['width']/4);
        $byteAsString = '';
        for ($i=0; $i< count($newBytes); $i++) {
            $lbreak = "";
            if ($withLB && $i > 0) {
                if ($i%$lineBreakCount == 0) {
                    $lbreak = "\n";
                }
            }
            $byteAsString .= chr($newBytes[$i]) . $lbreak;
        }
        $imageTemplate = "~DG" . $outputFileName . "," . count($newBytes);
        $imageTemplate .= "," . $byteW . "," . $byteAsString;
        if (! file_put_contents("../local/".$outputFileName, $imageTemplate)) {
            echo "Falhou ao gravar";
        }
	//FileOutputStream fos = new FileOutputStream(outputFileName + ".grf");
	//fos.write(imageTemplate.getBytes());
	//fos.close();
        //System.out.println("Finished!  Check for file \"" + outputFileName + ".grf\" in executing dir");        
        
        
        
    }
   
    
    
    public static function imagecreatefrombmp($filename)
    {
        //Ouverture du fichier en mode binaire
        if (!$fpointer = fopen($filename, "rb")) {
             return false;
        }
        //1 : Chargement des ent?tes FICHIER
        $file = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($fpointer, 14));
        if ($file['file_type'] != 19778) {
            return false;
        }
        //2 : Chargement des ent?tes BMP
        $param = 'Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel/Vcompression/Vsize_bitmap/Vhoriz_resolution/Vvert_resolution/Vcolors_used/Vcolors_important';
        $bmp = unpack($param, fread($fpointer, 40));
        
        $bmp['colors'] = pow(2, $bmp['bits_per_pixel']);
        
        if ($bmp['size_bitmap'] == 0) {
            $bmp['size_bitmap'] = $file['file_size'] - $file['bitmap_offset'];
        }
        
        $bmp['bytes_per_pixel'] = $bmp['bits_per_pixel'] / 8;
        $bmp['bytes_per_pixel2'] = ceil($bmp['bytes_per_pixel']);
        $bmp['decal'] = ($bmp['width'] * $bmp['bytes_per_pixel'] / 4);
        $bmp['decal'] -= floor($bmp['width'] * $bmp['bytes_per_pixel'] / 4);
        $bmp['decal'] = 4 - (4 * $bmp['decal']);
        if ($bmp['decal'] == 4) {
            $bmp['decal'] = 0;
        }
        //3 : Chargement des couleurs de la palette
        $pallete = array();
        if ($bmp['colors'] < 16777216) {
            $pallete = unpack('V'.$bmp['colors'], fread($fpointer, $bmp['colors']*4));
        }
        //4 : Cr?ation de l'image
        $img = fread($fpointer, $bmp['size_bitmap']);
        $vide = chr(0);
        $res = imagecreatetruecolor($bmp['width'], $bmp['height']);
        $pix = 0;
        $ypos = $bmp['height']-1;
        while ($ypos >= 0) {
            $xpos = 0;
            while ($xpos < $bmp['width']) {
                if ($bmp['bits_per_pixel'] == 24) {
                    $color = @unpack("V", substr($img, $pix, 3).$vide);
                } elseif ($bmp['bits_per_pixel'] == 16) {
                    $color = @unpack("n", substr($img, $pix, 2));
                    $color[1] = $palette[$color[1]+1];
                } elseif ($bmp['bits_per_pixel'] == 8) {
                    $color = @unpack("n", $vide.substr($img, $pix, 1));
                    $color[1] = $palette[$color[1]+1];
                } elseif ($bmp['bits_per_pixel'] == 4) {
                    $color = @unpack("n", $vide.substr($img, floor($pix), 1));
                    if (($pix * 2) % 2 == 0) {
                        $color[1] = ($color[1] >> 4);
                    } else {
                        $color[1] = ($color[1] & 0x0F);
                    }
                    $color[1] = $palette[$color[1]+1];
                } elseif ($bmp['bits_per_pixel'] == 1) {
                    $color = @unpack("n", $vide.substr($img, floor($pix), 1));
                    if (($pix * 8) % 8 == 0) {
                        $color[1] =  $color[1] >> 7;
                    } elseif (($pix * 8) % 8 == 1) {
                        $color[1] = ($color[1] & 0x40)>>6;
                    } elseif (($pix * 8) % 8 == 2) {
                        $color[1] = ($color[1] & 0x20)>>5;
                    } elseif (($pix * 8) % 8 == 3) {
                        $color[1] = ($color[1] & 0x10)>>4;
                    } elseif (($pix * 8) % 8 == 4) {
                        $color[1] = ($color[1] & 0x8)>>3;
                    } elseif (($pix * 8) % 8 == 5) {
                        $color[1] = ($color[1] & 0x4)>>2;
                    } elseif (($pix * 8) % 8 == 6) {
                        $color[1] = ($color[1] & 0x2)>>1;
                    } elseif (($pix * 8) % 8 == 7) {
                        $color[1] = ($color[1] & 0x1);
                    }
                    $color[1] = $pallete[$color[1]+1];
                } else {
                    return false;
                }
                imagesetpixel($res, $xpos, $ypos, $color[1]);
                $xpos++;
                $pix += $bmp['bytes_per_pixel'];
            }
            $ypos--;
            $pix += $bmp['decal'];
        }
        //Fermeture du fichier
        fclose($fpointer);
        return $res;
    }
}
