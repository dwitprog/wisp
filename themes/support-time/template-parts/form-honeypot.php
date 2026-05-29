<?php
/**
 * Honeypot: hidden “required” consent checkbox for bots.
 * Real users must not see or fill it; if checked, submission is faked client- and server-side.
 */
?>
<div class="form-honeypot" aria-hidden="true">
    <label class="consent">
        <input type="checkbox" name="privacy_ack" value="1" tabindex="-1" autocomplete="off">
        <span>I agree to the privacy policy and terms of service</span>
    </label>
</div>
