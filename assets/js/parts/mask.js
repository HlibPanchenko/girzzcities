(function ($) {
    $(document).ready(function() {
        let phoneNumber = $('#phone').text();
        let phoneNumberHeader = $('#phone-header-number').text();
        let phoneNumberContactsBlock = $('#phone-block').text();
        let phoneSinglePage = $('#single-pn').text();
        let formattedPhoneNumber = formatPhoneNumber(phoneNumber);
        let formattedPhoneNumberHeader = formatPhoneNumber(phoneNumberHeader);
        let formattedPhoneNumberContactsBlock = formatPhoneNumber(phoneNumberContactsBlock);
        let formattedPhoneSinglePage = formatPhoneNumber(phoneSinglePage);
        $('#phone').text(formattedPhoneNumber);
        $('#phone-header-number').text(formattedPhoneNumberHeader);
        $('#phone-block').text(formattedPhoneNumberContactsBlock);
        $('#single-pn').text(formattedPhoneSinglePage);
    });

    function formatPhoneNumber(phoneNumber) {
        let cleanedNumber = phoneNumber.replace(/\D/g, '');
        return '+7 (' + cleanedNumber.slice(1, 4) + ') ' + cleanedNumber.slice(4, 7) + '-' + cleanedNumber.slice(7, 9) + '-' + cleanedNumber.slice(9);
    }
})(jQuery);
