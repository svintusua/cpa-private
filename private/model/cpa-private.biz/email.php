<?php
class Email{
    public static $from_email;
  public static $from_name;
  public static $to_email;
  public static $to_name;
  public static $subject;
  public static $data_charset='UTF-8';
  public static $send_charset='windows-1251';
  public static $body='';
  public static $type='text/plain';
  public static $yes='';
  public static $no='';
  public static $errors='';
  public static $n='';
  
  public static function mimeHeaderEncode($str, $data_charset, $send_charset){
  if($data_charset != $send_charset)
    $str=iconv($data_charset,$send_charset.'//IGNORE',$str);
  return ('=?'.$send_charset.'?B?'.base64_encode($str).'?=');
  }
  
   public static function send(){
    $dc=  static::$data_charset;
    $sc=static::$send_charset;
    //Кодируем поля адресата, темы и отправителя
    $enc_to=static::mimeHeaderEncode(static::$to_name,$dc,$sc).' <'.static::$to_email.'>';
    $enc_subject=static::mimeHeaderEncode(static::$subject,$dc,$sc);
    $enc_from=static::mimeHeaderEncode(static::$from_name,$dc,$sc).' <'.static::$from_email.'>';
    //Кодируем тело письма
    $enc_body=$dc==$sc?static::$body:iconv($dc,$sc.'//IGNORE',static::$body);
    //Оформляем заголовки письма
    $headers='';
    $headers.="Mime-Version: 1.0\r\n";
    $headers.="Content-type: ".static::$type."; charset=".$sc."\r\n";
    $headers.="From: ".$enc_from."\r\n";
    //Отправляем
    return mail($enc_to,$enc_subject,$enc_body,$headers);
    }
}