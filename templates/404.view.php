Упс!!!

if ('POST' == $request->getMethod()) {

// Проверка капчи
$secret = '6LegxsIlAAAAACCnAkTUO-4sZhs6R4YtMGatbql8';
$baseUrl = 'https://www.google.com/recaptcha/api/siteverify';
$responseKey = $request->request->get('g-recaptcha-response');
$userIP = $request->server->get('REMOTE_ADDR');

$url = $baseUrl . "?secret=$secret&response=$responseKey&remoteip=$userIP";

try {
$responseRecaptcha = file_get_contents($url);

$encoder = new JsonEncoder();
$responseRecaptcha = $encoder->decode($responseRecaptcha, JsonEncoder::FORMAT);

if (!$responseRecaptcha["success"]) {
$this->notifier()->error('message.error.recaptcha_alert');
}

} catch (\Exception $e) {

$this->notifier()->error('message.error.recaptcha_error');
$responseRecaptcha["success"] = false;

return $this->redirectToRoute('account_registration');
}

if (!$this->options()->getValue('submarine_users.registration')) {
return $this->redirectToRoute('account_registration');
}
























<div class="control-row">
<div class="control-widget bl-blk-margin" >
<div class="g-recaptcha" data-sitekey="{{ gg_recaptcha_site_key }}"></div>
</div>
</div>
<div class="control-submit df-clear-wrap">
<div class="control-widget">
<button type="submit" class="bl-btn bl-btn-green">Регистрация</button>


</div>

<script type="text/javascript">
var onloadCallback = function() {
alert("grecaptcha is ready!");
};
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
