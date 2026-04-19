// Google Translate Init Function
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    includedLanguages: 'en,hi,es,fr,de,zh-CN,ar,ru,pt,ja',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element');
}

// Function to set cookie
function setCookie(key, value, expiry) {
  var expires = new Date();
  expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
  document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Create hidden Google Translate Div if it doesn't exist
    if (!document.getElementById('google_translate_element')) {
        var translateDiv = document.createElement('div');
        translateDiv.id = 'google_translate_element';
        translateDiv.style.display = 'none';
        document.body.appendChild(translateDiv);
    }

    // 2. Load API
    if (!document.querySelector('script[src*="translate.google.com"]')) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        document.body.appendChild(script);
    }

    // 3. Handle Language Switch using Cookie
    var dropdowns = document.querySelectorAll('.gbase-lang-switch');
    
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('change', function() {
            var selectedLanguage = this.value;
            var langCode = '';

            switch (selectedLanguage) {
                case 'English': langCode = 'en'; break;
                case 'Hindi': langCode = 'hi'; break;
                case 'Spanish': langCode = 'es'; break;
                case 'French': langCode = 'fr'; break;
                case 'German': langCode = 'de'; break;
                case 'Chinese': langCode = 'zh-CN'; break;
                case 'Arabic': langCode = 'ar'; break;
                case 'Russian': langCode = 'ru'; break;
                case 'Portuguese': langCode = 'pt'; break;
                case 'Japanese': langCode = 'ja'; break;
            }

            if (langCode) {
                // Set the Google Translate cookie: /sourceLang/targetLang
                // e.g., /en/es for English to Spanish
                setCookie('googtrans', '/en/' + langCode, 1); // 1 day expiry
                setCookie('googtrans', '/en/' + langCode, 1, '.gbase.co.in'); // try domain specific if needed ?
                
                // Force reload to apply the translation
                location.reload();
            }
        });
    });
});
