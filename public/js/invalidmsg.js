function InvalidMsg(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('2文字以上の検索キーワードを入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidName(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('ユーザー名を入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidEmail(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('メールアドレスを入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidPw(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('パスワードを入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidPwc(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('パスワード（確認用）を入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidSubject(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('件名を入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}

function InvalidInquiry(textbox) {
  if (textbox.value === '') {
      textbox.setCustomValidity('お問い合わせ内容を入力してください');
  } else {
     textbox.setCustomValidity('');
  }
  return true;
}
