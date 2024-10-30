<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * A sample admin form, taken from
 * http://codex.wordpress.org/Administration_Menus
 *
 */
//must check that the user has the required capability
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

// variables for the field and option names
$hidden_field_name = 'consent_for_ads_hidden';

// Read in existing option value from database
$terms_accepted = get_option( 'consent_for_ads_terms_accepted' );
// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if ( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {

	// Read their posted value
	check_admin_referer( 'consent_for_ads_options' );

	$terms_accepted = array_key_exists('consent_for_ads_terms_accepted', $_POST) && sanitize_text_field($_POST['consent_for_ads_terms_accepted']) == 'on' ? true : false;

	// Save the posted value in the database
	update_option( 'consent_for_ads_terms_accepted', $terms_accepted );
	?>

    <div class="updated"><p><strong><?php _e( 'Settings saved.', 'consent-for-ads' ); ?></strong></p></div>

	<?php
}

?>

<div class="um-cmp-admin-pane">

    <div class="header-row">
        <img class="pull-left" src="<?= plugin_dir_url( __FILE__ ) . 'img/logo-admin.png' ?>">
        <h1 class="pull-left"><?php echo __( 'ConsentForAds by UnveilMedia', 'consent-for-ads' ); ?></h1>
    </div>

    <form name="form" method="post" action="" style="display: block;">
		<?php wp_nonce_field( 'consent_for_ads_options' ) ?>
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <div class="form-group">

            <h3>Read and accept ConsentForAds Terms of Service</h3>
            <div class="terms-wrapper">
                <p class="c1"><span class="c0">Consent For Ads Terms of Service<br><br>Last Updated: May 21st, 2018<br><br>This Consent For Ads Terms of Service (this &ldquo;Agreement&rdquo;), describes the terms and conditions on which UnveilMedia makes Consent For Ads (the &ldquo;Solution&rdquo;) available to you.<br><br>BY USING THE SOLUTION, YOU ARE AGREEING TO BE BOUND BY THIS AGREEMENT. IF YOU ARE ENTERING INTO THIS AGREEMENT ON BEHALF OF A COMPANY OR OTHER LEGAL ENTITY, YOU REPRESENT THAT YOU HAVE THE AUTHORITY TO BIND SUCH ENTITY, IN WHICH CASE THE TERMS &ldquo;YOU&rdquo; OR &ldquo;YOUR&rdquo; WILL REFER TO SUCH ENTITY (OR, IF SUCH ENTITY IS ACTING AS AN AUTHORIZED THIRD PARTY, THEN THE TERMS &ldquo;YOU&rdquo; OR &ldquo;YOUR&rdquo; WILL REFER TO SUCH ENTITY, THE AUTHORIZING PARTY(IES), OR BOTH, AS APPLICABLE). UNVEILMEDIA MAY MODIFY THIS AGREEMENT FROM TIME TO TIME; CONTINUED USE 30 DAYS AFTER NOTIFICATION WILL CONSTITUTE ACCEPTANCE (SEE SECTION 6). PLEASE READ THIS AGREEMENT CAREFULLY.<br><br> &nbsp; &nbsp;1. Certain Definitions.<br><br> &nbsp; &nbsp; &nbsp; &ldquo;Applicable Privacy Laws&rdquo; means any applicable laws, statutes or regulations as may be amended, extended or re-enacted from time to time which relate to Personal Data including (i) the EU General Data Protection Regulation 2016/679 (&ldquo;GDPR&rdquo;) and any EU Member State laws implementing the GDPR, and (ii) the e-Privacy Directive 2002/58/EC, as amended and as transposed into EU Member State law and any legislation replacing the e-Privacy Directive.<br><br> &nbsp; &nbsp; &nbsp; &ldquo;CFA Tag&rdquo; means the particular JavaScript code, CMS Plugin or software development kit provided to you by UnveilMedia and embeddable on web pages or apps for implementation of the Solution, together with any fixes, updates and upgrades provided to you.<br><br> &nbsp; &nbsp; &nbsp; &ldquo;Consent Signal&rdquo; means the indication as to whether a website visitor or app user (i.e., end user) has provided valid consent or withheld or revoked consent for some or all of the third parties seeking to obtain the consent of such end user in accordance with the requirements of GDPR.<br><br> &nbsp; &nbsp; &nbsp; &ldquo;Personal Data&rdquo; has the same meaning ascribed to it in GDPR.<br><br> &nbsp; &nbsp;2. UnveilMedia Consent and Transparency Solution.<br><br> &nbsp; &nbsp; &nbsp; a. &nbsp;Solution. The Solution is a transparency and consent application that allows website operators and app developers to collect and manage Consent Signals. UnveilMedia will provide you with the CFA Tag and Consent For Ads Technical Guide in order for you to implement the Solution.<br><br> &nbsp; &nbsp; &nbsp; b. &nbsp;UnveilMedia Obligations and Representations. UnveilMedia agrees, represents and warrants to you that the Solution is compatible with the IAB Europe Open Transparency and Consent Framework.<br><br> &nbsp; &nbsp; &nbsp; c. &nbsp;Your Obligations and Representations. You agree, represent and warrant to UnveilMedia that you (i) have all rights, approvals, and consents necessary to implement the CFA Tag on webpages, apps or other digital applications, (ii) will implement the CFA Tag only as described in the Consent For Ads Technical Guide provided by UnveilMedia and the terms and conditions of this Agreement, and (iii) will not interfere or attempt to interfere with the operational features of the Solution, and (iv) will not delete, or in any manner alter, the copyright, trademark, or other proprietary rights notices appearing on the Solution.<br><br> &nbsp; &nbsp;3. Indemnity. You agree to defend, indemnify, and hold UnveilMedia harmless from any judgments, damages, loss, liability, or costs (including reasonable legal fees) resulting from a third-party claim resulting from your breach of a term of this Agreement or your use of the Solution. UnveilMedia will have no obligation or liability hereunder where the claim results from any combination with, addition to, or modification of the CFA Tag. Where pursuant to Article 82(4) of the GDPR, UnveilMedia is found to be liable for the entire damage arising from a breach or breaches of the GDPR relating to activities under this Agreement, in order to ensure effective compensation of a one or more individuals, then you shall indemnify UnveilMedia for all claims, demands, loss, damage or expense (including reasonable attorneys&rsquo; fees) relating to any breaches of GDPR for which you are wholly or partly responsible. All compensation paid to a data subject pursuant to Article 82(4) of the GDPR by UnveilMedia which is wholly or partly attributable to GDPR breaches by you shall be repaid pursuant to this indemnity and Article 82(5) immediately on receipt of a written request from UnveilMedia pursuant to this Section 3.<br><br> &nbsp; &nbsp;4. Warranty Disclaimer. The Solution provided &ldquo;as is,&rdquo; without warranty or condition of any kind, either express or implied. Without limiting the foregoing, UnveilMedia explicitly disclaims any warranties of merchantability, fitness for a particular purpose, quiet enjoyment, or non-infringement. UnveilMedia assumes no liability on behalf of you, any of your third party vendors, or any other entities for acting or not acting on Consent Signals, or if you or any of your third party vendors or any other entities bypass or otherwise interfere with the technical restrictions included in the Solution as provided by UnveilMedia. UnveilMedia makes no warranty that the Solution, including the CFA Tag, will (i) be available on an uninterrupted, secure, or error-free basis, (ii) not cause any latency or processing delays or (iii) meets any legal requirements around consent or data protection. UnveilMedia assumes no liability for your reliance on the Solution. The foregoing exclusions and disclaimers are an essential part of this Agreement and formed a basis for enabling UnveilMedia to offer the Solution to you. Some jurisdictions do not allow exclusion of certain warranties so this disclaimer may not apply to you in full.<br><br> &nbsp; &nbsp;5. Termination. Unless otherwise terminated as set forth herein, this Agreement will remain in full force and effect while you use the Solution. You may terminate this Agreement by removing the CFA Tag from your webpages or apps, as applicable, or notifying UnveilMedia of your termination of this Agreement at any time in writing. UnveilMedia may terminate access to the Solution or terminate this Agreement at any time, for any reason or no reason and without any liability to you. UnveilMedia will not be liable to you or any third party for termination of this Agreement. Notwithstanding the above, Sections 3 and 7 to 10 will survive termination<br><br> &nbsp; &nbsp;6. Modification of the Agreement. UnveilMedia reserves the right, in its sole discretion, to modify or discontinue the Solution without notice. UnveilMedia may also modify this Agreement from time to time. If the modified Agreement is not acceptable to you, you may terminate your account within 30 days by following the procedure in Section 5. Use of the Solution, after 30 days, will constitute your acceptance thereof<br><br> &nbsp; &nbsp;7. Limitation on Liability. IN NO EVENT WILL UNVEILMEDIA BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY CONSEQUENTIAL LOSS, EXEMPLARY DAMAGE, INCIDENTAL LOSS , SPECIAL DAMAGE OR LOSS, LOST PROFIT, OR PUNITIVE DAMAGES ARISING FROM YOUR USE OF THE SOLUTION, EVEN IF UNVEILMEDIA HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. THESE LIMITATIONS FORMED A BASIS FOR ENABLING UNVEILMEDIA TO OFFER THE SOLUTION TO YOU. THIS PARAGRAPH WILL APPLY REGARDLESS OF ANY FAILURE OF THE EXCLUSIVE REMEDY PROVIDED IN THE FOLLOWING PARAGRAPH. EXCEPT WITH REGARD TO LIABILITY STEMMING FROM DEATH OR PERSONAL INJURY RESULTING FROM UNVEILMEDIA&rsquo;S NEGLIGENCE, OR UNVEILMEDIA&rsquo;S FRAUD, NOTWITHSTANDING ANYTHING TO THE CONTRARY CONTAINED HEREIN, UNVEILMEDIA&rsquo;S LIABILITY TO YOU FOR ANY CAUSE WHATSOEVER AND REGARDLESS OF THE FORM OF THE ACTION, WILL AT ALL TIMES BE LIMITED TO TWO HUNDRED FIFTY DOLLARS (US $250.00).<br><br> &nbsp; &nbsp;8. Customer hereby grants to UnveilMedia the express right to use your company logo in marketing, sales, financial, and public relations materials and other communications solely to identify your company as an UnveilMedia customer. UnveilMedia hereby grants to you the express right to use UnveilMedia&rsquo;s logo solely to identify UnveilMedia as a provider of services to you. Other than as expressly stated herein, neither party shall use the other party&#39;s marks, codes, drawings or specifications without the prior written permission of the other party.</span></p><p class="c1 c2"><span class="c0"></span></p><p class="c1"><span class="c0">&nbsp; &nbsp; 9. Notices. All notices or other communications to UnveilMedia from you will be deemed given only when received by hand delivery, electronic mail, or prepaid first class mail, at the address above or any other address provided by UnveilMedia to you for these purposes, with attention to the Legal Department.<br><br>For all enquiries, please contact:<br><br>UnveilMedia Limited</span></p><p class="c1"><span class="c0">4th Floor,<br>85 Hatton Garden,<br>London,<br>EC1N 8JR</span></p><p class="c1"><span class="c0">Attn: Legal Department<br>Email: legal@unveilmedia.com</span></p><p class="c1 c2"><span class="c0"></span></p><p class="c1"><span class="c0">&nbsp; &nbsp; 9. Miscellaneous. This Agreement constitutes the entire Agreement between the parties with respect to the Solution and supersedes all previous and contemporaneous agreements, proposals, and communications, written or oral between UnveilMedia and you with respect thereto. Any waiver by either party of any violation of this Agreement will not be deemed to waive any further or future violation of the same or any other provision. If any parts or provisions of this Agreement are held to be unenforceable, then you and UnveilMedia agree that such parts or provisions will be given maximum permissible force and effect and the remainder of the Agreement will be fully enforceable. You and UnveilMedia agree that there are no third party beneficiaries of any promises, obligations or representations made by UnveilMedia. Either party may assign its rights, data, and duties, under this Agreement in their entirety in connection with a sale of all (or substantially all) of its assets relating to this Agreement, a merger, or a reorganization. Nothing in this Agreement will constitute a partnership or joint venture between you and UnveilMedia. THIS AGREEMENT AND ANY DISPUTE RELATING TO THIS AGREEMENT WILL BE GOVERNED BY THE LAWS OF ENGLAND AND WALES. YOU AND UNVEILMEDIA AGREE AND CONSENT THAT JURISDICTION, PROPER VENUE, AND THE MOST CONVENIENT FORUMS FOR ALL CLAIMS, ACTIONS, AND PROCEEDINGS OF ANY KIND RELATING TO UNVEILMEDIA OR THE MATTERS IN THIS AGREEMENT WILL BE EXCLUSIVELY IN COURTS LOCATED IN ENGLAND AND WALES. This Agreement is drafted in the English language. Any translation into another language is provided for convenience only. In the event of any inconsistency between the English language version and any translation, the English language version shall prevail.<br><br> &nbsp; &nbsp;10. Contacting Party.<br> &nbsp; &nbsp; &nbsp; &nbsp; This Agreement is between you and UnveilMedia Limited, a limited company registered in England and Wales. References to &ldquo;UnveilMedia&rdquo;, &ldquo;us&rdquo;, &ldquo;we&rdquo; and &ldquo;our&rdquo; mean UnveilMedia Limited.
            </div>
            <label for="consent_for_ads_terms_accepted" class="terms-accepted-label">
                <input type="checkbox"
                       id="consent_for_ads_terms_accepted"
                       name="consent_for_ads_terms_accepted" <?php echo($terms_accepted ? 'checked' : '') ?> />
                <?php _e( "I have read and accept ConsentForAds Terms of Service", 'consent-for-ads' ); ?>

            </label>

        </div>

        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save', 'consent-for-ads' ); ?>"/>
        </p>
    </form>

    <div class="um-footer">
        <div class="um-footer-right">
			<?php _e( 'Version', 'consent-for-ads' ); ?>: <?= CONSENT_FOR_ADS_VERSION ?>
        </div>
    </div>
</div>
