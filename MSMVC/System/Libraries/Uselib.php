﻿<?php
/**
	* MSMVC
	* @package MSMVC
	* @author Mustafa Çolakoğlu
	* @since Version 1.0

//---------------------------------------------------------------------------

	* MSMVC MSCache
	* @package MSMVC
	* @author Mustafa Çolakoğlu
**/
	class Uselib{
		static function formDataFix($degisken=false){
			if($degisken){
				$degisken=$this->findChange('"',"&#34",$degisken);
				$degisken=$this->findChange("%","&#37",$degisken);
				$degisken=$this->findChange("'","&#39",$degisken);
				$degisken=$this->findChange("?","&#63",$degisken);
				$degisken=$this->findChange("`","&#96",$degisken);
				$degisken=$this->findChange("‘","&#8216",$degisken);
				$degisken=$this->findChange("’","&#8217",$degisken);
				$degisken=$this->findChange("“","&#8220",$degisken);
				$degisken=$this->findChange("”","&#8221",$degisken);
				$degisken=$this->findChange(":","&#58",$degisken);
				$degisken=$this->findChange(";","&#59",$degisken);
				$degisken=$this->findChange("<","&#60",$degisken);
				$degisken=$this->findChange("=","&#61",$degisken);
				$degisken=$this->findChange(">","&#62",$degisken);
				return $degisken;
			}
			else{
				foreach($_POST as $key=>$value){
					$_POST[$key]=$this->findChange('"',"&#34",$_POST[$key]);
					$_POST[$key]=$this->findChange("%","&#37",$_POST[$key]);
					$_POST[$key]=$this->findChange("'","&#39",$_POST[$key]);
					$_POST[$key]=$this->findChange("?","&#63",$_POST[$key]);
					$_POST[$key]=$this->findChange("`","&#96",$_POST[$key]);
					$_POST[$key]=$this->findChange("‘","&#8216",$_POST[$key]);
					$_POST[$key]=$this->findChange("’","&#8217",$_POST[$key]);
					$_POST[$key]=$this->findChange("“","&#8220",$_POST[$key]);
					$_POST[$key]=$this->findChange("”","&#8221",$_POST[$key]);
					$_POST[$key]=$this->findChange(":","&#58",$_POST[$key]);
					$_POST[$key]=$this->findChange(";","&#59",$_POST[$key]);
					$_POST[$key]=$this->findChange("<","&#60",$_POST[$key]);
					$_POST[$key]=$this->findChange("=","&#61",$_POST[$key]);
					$_POST[$key]=$this->findChange(">","&#62",$_POST[$key]);
				}
				foreach($_GET as $key=>$value){
					$_GET[$key]=$this->findChange('"',"&#34",$_GET[$key]);
					$_GET[$key]=$this->findChange("%","&#37",$_GET[$key]);
					$_GET[$key]=$this->findChange("'","&#39",$_GET[$key]);
					$_GET[$key]=$this->findChange("?","&#63",$_GET[$key]);
					$_GET[$key]=$this->findChange("`","&#96",$_GET[$key]);
					$_GET[$key]=$this->findChange("‘","&#8216",$_GET[$key]);
					$_GET[$key]=$this->findChange("’","&#8217",$_GET[$key]);
					$_GET[$key]=$this->findChange("“","&#8220",$_GET[$key]);
					$_GET[$key]=$this->findChange("”","&#8221",$_GET[$key]);
					$_GET[$key]=$this->findChange(":","&#58",$_GET[$key]);
					$_GET[$key]=$this->findChange(";","&#59",$_GET[$key]);
					$_GET[$key]=$this->findChange("<","&#60",$_GET[$key]);
					$_GET[$key]=$this->findChange("=","&#61",$_GET[$key]);
					$_GET[$key]=$this->findChange(">","&#62",$_GET[$key]);
				}
			}
		}
		static function formDataFixWithoutHtml($degisken=false){
			$tab = "	";
			if($degisken){
				$degisken=$this->findChange('"',"&#34",$degisken);
				$degisken=$this->findChange("%","&#37",$degisken);
				$degisken=$this->findChange("'","&#39",$degisken);
				$degisken=$this->findChange("?","&#63",$degisken);
				$degisken=$this->findChange("`","&#96",$degisken);
				$degisken=$this->findChange("‘","&#8216",$degisken);
				$degisken=$this->findChange("’","&#8217",$degisken);
				$degisken=$this->findChange("“","&#8220",$degisken);
				$degisken=$this->findChange("”","&#8221",$degisken);
				$degisken=$this->findChange(":","&#58",$degisken);
				$degisken=$this->findChange(";","&#59",$degisken);
				$degisken=$this->findChange(" ","&nbsp;",$degisken);
				$degisken=$this->findChange($tab,"&nbsp;&nbsp;&nbsp;&nbsp;",$degisken);
				return $degisken;
			}
			else{
				foreach($_POST as $key=>$value){
					$_POST[$key]=$this->findChange('"',"&#34",$_POST[$key]);
					$_POST[$key]=$this->findChange("%","&#37",$_POST[$key]);
					$_POST[$key]=$this->findChange("'","&#39",$_POST[$key]);
					$_POST[$key]=$this->findChange("?","&#63",$_POST[$key]);
					$_POST[$key]=$this->findChange("`","&#96",$_POST[$key]);
					$_POST[$key]=$this->findChange("‘","&#8216",$_POST[$key]);
					$_POST[$key]=$this->findChange("’","&#8217",$_POST[$key]);
					$_POST[$key]=$this->findChange("“","&#8220",$_POST[$key]);
					$_POST[$key]=$this->findChange("”","&#8221",$_POST[$key]);
					$_POST[$key]=$this->findChange(":","&#58",$_POST[$key]);
					$_POST[$key]=$this->findChange(";","&#59",$_POST[$key]);
					$_POST[$key]=$this->findChange(" ","&nbsp;",$_POST[$key]);
					$_POST[$key]=$this->findChange($tab,"&nbsp;&nbsp;&nbsp;&nbsp;",$_POST[$key]);
				}
				foreach($_GET as $key=>$value){
					$_GET[$key]=$this->findChange('"',"&#34",$_GET[$key]);
					$_GET[$key]=$this->findChange("%","&#37",$_GET[$key]);
					$_GET[$key]=$this->findChange("'","&#39",$_GET[$key]);
					$_GET[$key]=$this->findChange("?","&#63",$_GET[$key]);
					$_GET[$key]=$this->findChange("`","&#96",$_GET[$key]);
					$_GET[$key]=$this->findChange("‘","&#8216",$_GET[$key]);
					$_GET[$key]=$this->findChange("’","&#8217",$_GET[$key]);
					$_GET[$key]=$this->findChange("“","&#8220",$_GET[$key]);
					$_GET[$key]=$this->findChange("”","&#8221",$_GET[$key]);
					$_GET[$key]=$this->findChange(":","&#58",$_GET[$key]);
					$_GET[$key]=$this->findChange(";","&#59",$_GET[$key]);
					$_GET[$key]=$this->findChange(" ","&nbsp;",$degisken);
					$_GET[$key]=$this->findChange($tab,"&nbsp;&nbsp;&nbsp;&nbsp;",$_GET[$key]);
				}
			}
		}
		static function findChange($bul,$degistir,$yazi){
			$yeni="";
			for($i=0;$i<strlen($yazi);$i++){
				if($bul==substr($yazi,$i,strlen($bul))){
					$i+=strlen($bul)-1;
					$yeni=$yeni.$degistir;
				}
				else{
					$yeni=$yeni.$yazi[$i];
				}
			}
			return $yeni;
		}
		static function clean($temizlenen,$belirli=false){
			if(!$belirli){
				$cikar="'".'";/.,*=-+qwertyuıopğüasdfghjklşizxcvbnmöçQWERTYUIOPĞÜASDFGHJKLŞİZXCVBNMÖÇ';
			}
			else{
				$cikar=$belirli;
			}
			$count=strlen($cikar);
			$temizle=$temizlenen;
			for($i=0;$i<$count;$i++){
				$temizle=str_replace(substr($cikar,$i,1),"",$temizle);
			}
			return $temizle;
		}
		static function take($baslanacak,$bitecek,$veri){
			$al=0;
			$yeniVeriler=array();
			$yeniVeri = "";
				$eklenen = 0;
				for($i=0;$i<=strlen($veri);$i++){
					if(substr($veri,$i,strlen($baslanacak))==$baslanacak){
						$al=1;
					}
					if(substr($veri,$i,strlen($bitecek))==$bitecek){
						$al=0;
						array_push($yeniVeriler,$veri);
						$yeniVeri = "";
						$eklenen++;
					}
					if($al==1){
						$yeniVeri=$yeniVeri.substr($veri,$i,1);
					}
				}
			return $yeniVeriler;
		}
		static function seflink($baslik){
			$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
			$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
			$perma = strtolower(str_replace($bul, $yap, $baslik));
			$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
			$perma = trim(preg_replace('/\s+/',' ', $perma));
			$perma = str_replace(' ', '-', $perma);
			return $perma;
		}
	}
?>