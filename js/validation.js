function validatePhoneNumber(phoneNumber) {
    if (phoneNumber.length == 13) {
        if (phoneNumber.startsWith('+254')) {
            if (phoneNumber.charAt(4) == 7 || phoneNumber.charAt(4) == 1) {
                 // Check if all characters except the first four are numbers
                 for (var i = 5; i < phoneNumber.length; i++) {
                    if (isNaN(phoneNumber[i])) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}