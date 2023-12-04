<?php
  // 宛先
  $to = "info@clean-labo.net";
  $from = "From: noreply@clean-labo.net";
  $title = "遺品整理に関するお問い合わせ";
  $title_for_customer = "【クリーンラボ】お問い合わせありがとうございます。";
  $content = "";
  $content_for_customer = "";

  if(empty($_POST)) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(['status' => "error"]);
    exit();
  }

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
  // お名前
  $customer_name = $_POST['customer_name'];
  $email         = $_POST['email'];
  $zip           = $_POST['zip'];
  $pref          = $_POST['pref'];
  $addr          = $_POST['addr'];
  $tel         = $_POST['tel'];
  $plan   = $_POST['plan'];
  $kaishukiboubi = $_POST['kaishukiboubi'];
  $aimitsu = $_POST['aimitsu'];
  $message       = $_POST['message'];
  if(!empty($customer_name)
    && !empty($email)
    && !empty($zip)
    && !empty($pref)
    && !empty($addr)
    && !empty($tel)
    && !empty($plan)
    && !empty($kaishukiboubi)
    && !empty($aimitsu)) {

    $content = "お名前:" . $customer_name . "\n" .
    "メールアドレス:" . $email . "\n" .
    "郵便番号:" . $zip . "\n" .
    "都道府県:" . $pref . "\n" .
    "住所:" . $addr . "\n" .
    "電話番号:" . $tel . "\n" .
    "プラン:" . $plan . "\n" .
    "回収希望日:" . $kaishukiboubi . "\n" .
    "他社と相見積もり中ですか:" . $aimitsu . "\n" .
    "本文:" . $message;

    $content_for_customer = "下記内容で承りました。" . "\n" . $content;
    
    if(mb_send_mail($to, $title, $content, $from)){
      if(mb_send_mail($email, $title_for_customer, $content_for_customer, $from)){
      // echo "メールを送信しました";
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(['status' => "success"]);
      } else {
        // echo "メールの送信に失敗しました";
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(['status' => "error"]);
      };
    } else {
      // echo "メールの送信に失敗しました";
      header('Content-type: application/json; charset=utf-8');
      echo json_encode(['status' => "error"]);
    };

  } else {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(['status' => "error"]);
    exit();
  }
?>