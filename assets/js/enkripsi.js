var key = "Fx53l3r4x51n3rg1ali53l3r4xxM4rtx";
var iv = "x51n3rg1x53l3r4x";

// Function enctypt
function encrypt(data = null) {
	var encrypted = CryptoJS.AES.encrypt(data, CryptoJS.enc.Utf8.parse(key), {
		mode: CryptoJS.mode.CBC,
		iv: CryptoJS.enc.Utf8.parse(iv),
	});
	var r1 = encrypted.ciphertext.toString(); // def44f8822cfb3f317a3c5b67182b437
	var resultEncrypt = CryptoJS.enc.Base64.stringify(encrypted.ciphertext); // 3vRPiCLPs/MXo8W2cYK0Nw==
	return resultEncrypt;
}

function decrypt(data = null) {
	var decrypted = CryptoJS.AES.decrypt(data, CryptoJS.enc.Utf8.parse(key), {
		iv: CryptoJS.enc.Utf8.parse(iv),
	});
	var resultDecrypt = decrypted.toString(CryptoJS.enc.Utf8);
	return resultDecrypt;
}
