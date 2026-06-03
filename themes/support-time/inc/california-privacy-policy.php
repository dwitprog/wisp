<?php

/**
 * California Privacy Policy (CCPA): контент, виртуальная страница, автосоздание записи.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @param string $title
 * @param string $article_attributes
 */
function st_render_california_privacy_policy_main(string $title, string $article_attributes = 'class="post"'): void
{
    $site_url = function_exists('st_legal_site_url') ? st_legal_site_url() : 'https://complexwisps.com';
    $privacy_url = $site_url . '/privacy-policy/';
    $ccpa_email = 'ccpaprivacy@complexwisps.com';
    $ccpa_mailto = 'mailto:' . $ccpa_email;
    $phone_display = '+1 971 534 7250';
    $phone_tel = 'tel:+19715347250';
    ?>
<main id="main" class="site-main page-h1">
    <div class="container">
        <h1><?php echo esc_html($title); ?></h1>
        <article <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $article_attributes;
        ?>>
            <p><strong>Effective Date:</strong> February 10, 2026.</p>
            <p><strong>Last Reviewed on:</strong> February 10, 2026.</p>

            <p>
                This California Privacy Policy describes how WispsMedia LLC, an Oregon limited liability company
                (&ldquo;Company,&rdquo; &ldquo;we,&rdquo; or &ldquo;us&rdquo;) collects and processes personal information about our consumers who reside in California.
                The California Consumer Privacy Act (&ldquo;CCPA&rdquo;) requires us to provide our California consumers with a privacy policy that contains a comprehensive
                description of our online and offline practices regarding our collection, use, sale, sharing, and retention of their personal information, along with a
                description of the rights they have regarding their personal information. This Privacy Policy provides the information the CCPA requires, together with
                other useful information regarding our collection and use of personal information. Any terms defined in the CCPA have the same meaning when used in this policy.
            </p>
            <p>
                This Privacy Policy does not apply to our collection and use of personal information from residents outside of California.
                Consumers residing in other locations should see our general privacy policy at:
                <a href="<?php echo esc_url($privacy_url); ?>"><?php echo esc_html($privacy_url); ?></a>.
            </p>

            <h2>Personal Information Collected</h2>
            <p>
                We collect and use information that identifies, relates to, describes, references, is reasonably capable of being associated with, or could reasonably be
                linked, directly or indirectly, with a particular consumer or household (&ldquo;personal information&rdquo;). Personal information does not include:
            </p>
            <ul>
                <li>Publicly available information, including from government records, through widely distributed media, or that the consumer made publicly available without restricting it to a specific audience.</li>
                <li>Lawfully obtained, truthful information that is a matter of public concern.</li>
                <li>Deidentified or aggregated consumer information.</li>
            </ul>

            <h2>Personal Information Categories Chart</h2>
            <p>
                The chart below identifies the categories of personal information we collected from our consumers within the last 12 months and the expected retention period.
            </p>
            <div class="legal-table-wrap">
                <table class="legal-table">
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Examples</th>
                            <th scope="col">Collected</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>A. Identifiers.</strong></td>
                            <td>A real name, alias, postal address, unique personal identifier, online identifier, Internet Protocol address, email address, account name, Social Security number, driver&rsquo;s license number, passport number, or other similar identifiers.</td>
                            <td>YES</td>
                        </tr>
                        <tr>
                            <td><strong>B. Personal information categories listed in the California Customer Records statute (Cal. Civ. Code &sect; 1798.80(e)) (&ldquo;California Customer Records&rdquo;).</strong></td>
                            <td>A name, signature, Social Security number, physical characteristics or description, address, telephone number, passport number, driver&rsquo;s license or state identification card number, insurance policy number, education, employment, employment history, bank account number, credit card number, debit card number, or any other financial information, medical information, or health insurance information. Some personal information included in this category may overlap with other categories.</td>
                            <td>YES</td>
                        </tr>
                        <tr>
                            <td><strong>C. Protected classification characteristics under California or federal law (&ldquo;Protected Classes&rdquo;).</strong></td>
                            <td>Age (40 years or older), race, color, ancestry, national origin, citizenship, religion or creed, marital status, medical condition, physical or mental disability, sex (including gender, gender identity, gender expression, pregnancy or childbirth and related medical conditions), sexual orientation, reproductive health decision-making, military and veteran status, or genetic information (including familial genetic information).</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>D. Commercial information.</strong></td>
                            <td>Records of personal property, products, or services purchased, obtained, or considered, or other purchasing or consuming histories or tendencies.</td>
                            <td>YES</td>
                        </tr>
                        <tr>
                            <td><strong>E. Biometric information.</strong></td>
                            <td>Genetic, physiological, behavioral, and biological characteristics, or activity patterns used to extract a template or other identifier or identifying information, such as fingerprints, faceprints, and voiceprints, iris or retina scans, keystroke, gait, or other physical patterns, and sleep, health, or exercise data.</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>F. Internet or other similar network activity.</strong></td>
                            <td>Activity on our websites, mobile apps, or other digital systems, such as internet browsing history, search history, system usage, or electronic communications with us.</td>
                            <td>YES</td>
                        </tr>
                        <tr>
                            <td><strong>G. Geolocation data.</strong></td>
                            <td>Physical location or movement, such as your zip code, the time and physical location related to use of our internet website or mobile application, or other information about your location or locations you visited.</td>
                            <td>YES</td>
                        </tr>
                        <tr>
                            <td><strong>H. Sensory data.</strong></td>
                            <td>Audio, electronic, visual, thermal, olfactory, or similar information, including customer service call monitoring and store video surveillance.</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>I. Professional or employment-related information.</strong></td>
                            <td>Current or past job history or performance evaluations.</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>J. Non-public education information (per FERPA) (&ldquo;FERPA Information&rdquo;).</strong></td>
                            <td>Education records directly related to a student maintained by an educational institution or party acting on its behalf, such as grades, transcripts, class lists, student schedules, student identification codes, student financial information, or student disciplinary records.</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>K. Inferences drawn from other personal information.</strong></td>
                            <td>Profile reflecting a person&rsquo;s preferences, characteristics, psychological trends, predispositions, behavior, attitudes, intelligence, abilities, and aptitudes.</td>
                            <td>NO</td>
                        </tr>
                        <tr>
                            <td><strong>L. Sensitive personal information.</strong></td>
                            <td>Further identified in the chart below.</td>
                            <td>NO</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2>Sensitive Personal Information Categories Chart</h2>
            <p>
                Sensitive personal information is a subtype of personal information consisting of the specific information categories listed in the chart below.
                Importantly, the CCPA only treats this information as sensitive personal information when we collect or use it to infer characteristics about a consumer.
                The chart below identifies which sensitive personal information categories, if any, we have collected from consumers to infer characteristics about them in the last 12 months.
            </p>
            <div class="legal-table-wrap">
                <table class="legal-table">
                    <thead>
                        <tr>
                            <th scope="col">Sensitive Personal Information Category</th>
                            <th scope="col">Collected to Infer Characteristics?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $spi_rows = array(
                            'L.1. Government identifiers, such as your Social Security number (SSN), driver\'s license, state identification card, or passport number.' => 'NO',
                            'L.2. Complete account access credentials, such as usernames, account logins, account numbers, or card numbers combined with required access/security code or password.' => 'NO',
                            'L.3. Precise geolocation, such as GPS data from a consumer\'s mobile device that can provide its location in a geographic area, with an approximate radius of 1,850 feet.' => 'NO',
                            'L.4. Racial or ethnic origin.' => 'NO',
                            'L.5. Citizenship or immigration status.' => 'NO',
                            'L.6. Religious or philosophical beliefs.' => 'NO',
                            'L.7. Union membership.' => 'NO',
                            'L.8. Mail, email, or text messages not directed to the Company.' => 'NO',
                            'L.9. Genetic data.' => 'NO',
                            'L.10. Neural Data, such as information generated by measuring a consumer\'s central or peripheral nervous system\'s activity that is not inferred from nonneural information.' => 'NO',
                            'L.11. Unique identifying biometric information.' => 'NO',
                            'L.12. Health information.' => 'NO',
                            'L.13. Sex life or sexual orientation information.' => 'NO',
                            'L.14. Children\'s personal information (under age 16).' => 'NO',
                        );
                        foreach ($spi_rows as $label => $collected) :
                            ?>
                        <tr>
                            <td><?php echo esc_html($label); ?></td>
                            <td><?php echo esc_html($collected); ?></td>
                        </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

            <h2>Sources of Personal Information</h2>
            <p>We obtain the categories of personal information listed above from the following categories of sources:</p>
            <ul>
                <li>Directly from you, such as from the forms or other information you provide to the Company.</li>
                <li>From our service providers, such as customer service support providers, and data analytics providers.</li>
                <li>Inferences generated by the Company&rsquo;s or our service providers&rsquo; computer systems.</li>
            </ul>

            <h2>How We Use Personal Information</h2>
            <h3>Personal Information Collection, Use, and Disclosure Purposes</h3>
            <p>We may use and disclose the personal information we collect to advance the Company&rsquo;s business and commercial purposes, specifically to:</p>
            <ul>
                <li>Develop, offer, and provide you with our products and services.</li>
                <li>Meet our obligations and enforce our rights arising from any contracts with you, including for billing or collections, or to comply with legal requirements.</li>
                <li>Fulfil the purposes for which you provided your personal information or that were described to you at collection, and as the CCPA otherwise permits.</li>
                <li>Improve our products or services, marketing, or customer relationships and experiences.</li>
                <li>Notify you about changes to our products or services.</li>
                <li>Administer our systems and conduct internal operations, including for troubleshooting, data analysis, testing, research, statistical, and survey purposes.</li>
                <li>Protect our Company, employees, or operations.</li>
                <li>Measure or understand the effectiveness of the advertising we serve to you and others, and to deliver relevant advertising to you.</li>
                <li>Manage your consumer relationship with us, including for maintenance, and security.</li>
                <li>Perform data analytics and benchmarking.</li>
                <li>Administer and maintain the Company&rsquo;s systems and operations, including for safety purposes.</li>
                <li>Engage in corporate transactions requiring review of consumer records, such as for evaluating potential Company mergers and acquisitions.</li>
                <li>Comply with all applicable laws and regulations.</li>
                <li>Exercise or defend the legal rights of the Company and its employees, affiliates, customers, contractors, and agents.</li>
                <li>Respond to law enforcement requests and as required by applicable law or court order.</li>
            </ul>

            <h3>Additional Categories or Other Purposes</h3>
            <p>
                We will not collect additional categories of personal information or use the personal information we collected for materially different, unrelated, or incompatible purposes without providing you notice. If required by law, we will also seek your consent before using your personal information for a new or unrelated purpose.
            </p>
            <p>
                We may collect, process, and disclose aggregated or deidentified consumer information for any purpose, without restriction. When we collect, process, or disclose aggregated or deidentified consumer information, we will maintain and use it in deidentified form and will not attempt to reidentify the information, except to determine whether our deidentification processes satisfies any applicable legal requirements.
            </p>

            <h2>Disclosing, Selling, or Sharing Personal Information</h2>
            <h3>Business Purpose Disclosures</h3>
            <p>We have not disclosed consumers&rsquo; personal information to third parties for a business purpose in the preceding 12 months.</p>
            <h3>Selling or Sharing Personal Information</h3>
            <p>
                We do not sell your personal information to third parties and have not sold it in the preceding 12 months. We may share your personal information with third parties for cross-context behavioral advertising purposes but have not shared your personal information in the preceding 12 months.
            </p>

            <h2>Your Rights and Choices</h2>
            <p>If you are a California resident, the CCPA grants you the following rights regarding your personal information:</p>

            <h3>Right to Know and Data Portability Requests</h3>
            <p>
                You have the right to request that we disclose certain information to you about our collection and use of your personal information (the &ldquo;right to know&rdquo;), including the specific pieces of personal information we have collected about you (a &ldquo;data portability request&rdquo;). You may exercise your right to know twice in any 12-month period. Once we receive your request and confirm your identity (see How to Exercise Your Rights), we will disclose to you:
            </p>
            <ul>
                <li>The categories of personal information we collected about you and sources from which we collected your personal information.</li>
                <li>The business or commercial purpose for collecting your personal information and, if applicable, selling or sharing your personal information.</li>
                <li>If applicable, the categories of persons, including third parties, to whom we disclosed your personal information, including separate disclosures identifying the categories of your personal information that we: (a) disclosed for a business purpose to each category of persons; and (ii) sold or shared to each category of third parties.</li>
                <li>When your right to know submission includes a data portability request, a copy of your personal information, subject to any permitted redactions.</li>
            </ul>

            <h3>Right to Delete and Right to Correct</h3>
            <p>
                You have the right to request that we delete any of your personal information that we collected from you and retained, subject to certain exceptions and limitations (the &ldquo;right to delete&rdquo;). Once we receive your request and confirm your identity, we will delete your personal information from our systems unless an exception allows us to retain it. We will also notify our service providers contractors, and other recipients to take appropriate action.
            </p>
            <p>
                You also have the right to request correction of personal information we maintain about you that you believe is inaccurate (the &ldquo;right to correct&rdquo;). We may require you to provide documentation, if needed, to confirm your identity and support your claim that the information is inaccurate. Unless an exception applies, we will correct personal information that our review determines is inaccurate and notify our service providers, contractors, and other recipients to take appropriate action.
            </p>

            <h3>Right to Limit Sensitive Personal Information Use and Disclosure to Permitted SPI Purposes</h3>
            <p>
                You have a right to ask businesses that use or disclose your sensitive personal information to limit those actions to just the CCPA&rsquo;s Permitted SPI Purposes (the &ldquo;right to limit&rdquo;). As we do not use or disclose sensitive personal information beyond the CCPA&rsquo;s Permitted SPI Purposes, we do not currently provide this consumer right.
            </p>

            <h3>Personal Information Sharing Opt-Out and Opt-In Rights</h3>
            <p>
                You have the right to request that businesses stop sharing your personal information at any time (the &ldquo;right to opt-out&rdquo;), including through a user-enabled opt-out preference signal. Similarly, the CCPA prohibits businesses from selling or sharing the personal information of consumers it actually knows are under 16 years old without first obtaining consent from consumers who are between 13 and 15 years old or the consumer&rsquo;s parent or guardian for consumers under age 13 (the &ldquo;right to opt-in&rdquo;).
            </p>
            <p>We cannot share your personal information after we receive your request to opt-out unless you later consent to the sharing of your personal information.</p>

            <h3>Right to Non-Discrimination</h3>
            <p>You have the right not to be discriminated or retaliated against for exercising any of your privacy rights under the CCPA.</p>

            <h2>How to Exercise Your Rights</h2>
            <h3>Exercising the Rights to Know, Delete, or Correct</h3>
            <p>To exercise the right to know (including data portability), delete, or correct described above, please submit a verifiable request to us by either:</p>
            <ul>
                <li>Calling us at <a href="<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_display); ?></a>.</li>
                <li>Emailing us at <a href="<?php echo esc_url($ccpa_mailto); ?>"><?php echo esc_html($ccpa_email); ?></a>.</li>
            </ul>
            <p>
                Please describe your request with sufficient detail so we can properly understand, evaluate, and respond to it. You or your authorized agent may only submit a request to know, including for data portability, twice in a 12-month period.
            </p>

            <h3>Exercising the Right to Opt-Out</h3>
            <p>You can submit your request to opt-out through:</p>
            <ul>
                <li>Calling us at <a href="<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_display); ?></a>.</li>
                <li>Emailing us at <a href="<?php echo esc_url($ccpa_mailto); ?>"><?php echo esc_html($ccpa_email); ?></a>.</li>
            </ul>

            <h3>Verification Process and Authorized Agents</h3>
            <p>
                Only you, or someone legally authorized to act on your behalf, may make a request to know, delete, or correct related to your personal information. We may request specific information from you or your authorized representative to confirm your or their identity before we can process your right to know, delete, or correct your personal information.
            </p>
            <p>
                We cannot respond to your request to know, delete, or correct if we cannot verify your identity or authority to make the request and confirm the personal information relating to you.
            </p>
            <p>For requests to opt-out, we ask for the information necessary to complete the request, which may include, for example, the consumer&rsquo;s name or email address.</p>

            <h3>Responding to Your Requests to Know, Delete, or Correct</h3>
            <p>
                We will confirm receipt of your request within ten business days. If you do not receive confirmation within the ten-day timeframe, please email us at
                <a href="<?php echo esc_url($ccpa_mailto); ?>"><?php echo esc_html($ccpa_email); ?></a>.
            </p>
            <p>
                We endeavor to substantively respond to a verifiable request within 45 days of its receipt. If we require more time (up to another 45 days), we will inform you of the reason and extension period in writing. We will deliver our written response to your verified email address. Our substantive response will tell you whether or not we have complied with your request. If we cannot comply with your request in whole or in part, we will explain the reason, subject to any legal or regulatory restrictions. Applicable law may allow or require us to refuse to provide you with access to some or all of the personal information that we hold about you, or we may have destroyed, deleted, or made your personal information anonymous in compliance with our record retention policies and obligations.
            </p>
            <p>
                Any disclosures we provide will cover information for the 12-month period preceding the request&rsquo;s receipt date. We will consider requests to provide a longer disclosure period that do not extend past January 1, 2022, unless providing the longer timeframe would be impossible or involves disproportionate effort.
            </p>
            <p>For data portability requests, we will select a format to provide your personal information that is readily useable and should allow you to transmit the information from one entity to another entity without hindrance.</p>
            <p>
                We do not charge a fee to process or respond to your verifiable request unless it is excessive, repetitive, or manifestly unfounded. If we determine that the request warrants a fee, we will tell you why we made that decision and provide you with a cost estimate before completing your request.
            </p>

            <h3>Response and Timing on Rights to Opt-Out</h3>
            <p>
                In response to your request to opt-out, we will process your request, as soon as feasibly possible, but no later than 15 business days from the date we receive the request. We will only use personal information provided from your request to comply with the request.
            </p>
            <p>We will also notify our service providers, contractors, and certain other downstream recipients of your request to opt-out and instruct them to both:</p>
            <ul>
                <li>Comply with your request.</li>
                <li>Forward the request to their own downstream recipients, if applicable.</li>
            </ul>
            <p>We may deny opt-out requests if we have a good-faith, reasonable, and documented belief that the request is fraudulent and will clearly explain our denial decision to the requestor.</p>

            <h2>How We Protect Your Personal Data</h2>
            <p>
                We use commercially reasonable administrative, physical, and technical measures designed to protect your personal data from accidental loss or destruction and from unauthorized access, use, alteration, and disclosure. However, no website, mobile application, system, electronic storage, or online service is completely secure, and we cannot guarantee the security of your personal data transmitted to, through, using, or in connection with the Services. In particular, email, texts, and chats sent to or from the Services may not be secure, and you should carefully decide what information you send to us through these communication channels. Any transmission of personal data is at your own risk.
            </p>
            <p>
                The safety and security of your information also depends on you. You are responsible for taking steps to protect your personal data against unauthorized use, disclosure, and access.
            </p>

            <h2>Privacy Policy Changes</h2>
            <p>
                We reserve the right to update this Privacy Policy at any time, as we continue to develop our compliance program in response to legal developments of the CCPA. If we make any material changes to this Privacy Policy, we will update the policy&rsquo;s effective date. We encourage you to review the current Privacy Policy in effect. See also our
                <a href="<?php echo esc_url($privacy_url); ?>">general Privacy Policy</a>.
            </p>

            <h2>Contact Information</h2>
            <p>
                If you have any questions or comments about this policy, the ways in which we collect and use your information described here, your choices and rights regarding such use, or wish to exercise your rights under California law, please do not hesitate to contact us at:
            </p>
            <p>
                Phone: <a href="<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_display); ?></a><br>
                Email: <a href="<?php echo esc_url($ccpa_mailto); ?>"><?php echo esc_html($ccpa_email); ?></a>
            </p>
            <p>
                If you need to access this Privacy Policy in an alternative format due to a disability, please contact
                <a href="<?php echo esc_url($ccpa_mailto); ?>"><?php echo esc_html($ccpa_email); ?></a>.
            </p>
        </article>
    </div>
</main>
    <?php
}

/**
 * Создаёт страницу california-privacy-policy при возможности.
 */
function st_ensure_california_privacy_policy_page_callback(): void
{
    if (wp_installing() || wp_doing_ajax()) {
        return;
    }

    if (!current_user_can('publish_pages')) {
        return;
    }

    $slug = 'california-privacy-policy';
    $existing = get_posts(
        array(
            'post_type' => 'page',
            'name' => $slug,
            'post_status' => array('publish', 'draft', 'pending', 'private'),
            'posts_per_page' => 1,
            'fields' => 'ids',
            'no_found_rows' => true,
        )
    );

    if (!empty($existing)) {
        return;
    }

    $id = wp_insert_post(
        array(
            'post_title' => 'California Privacy Policy (CCPA)',
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        ),
        true
    );

    if (!is_wp_error($id) && $id) {
        flush_rewrite_rules(false);
    }
}

add_action('after_switch_theme', 'st_ensure_california_privacy_policy_page_callback');
add_action('admin_init', 'st_ensure_california_privacy_policy_page_callback');

/**
 * Виртуальная страница при отсутствии записи в БД.
 */
function st_california_privacy_policy_maybe_virtual(): void
{
    if (is_admin()) {
        return;
    }

    $path = isset($_SERVER['REQUEST_URI']) ? (string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    $path = trim($path, '/');
    if ($path !== 'california-privacy-policy') {
        return;
    }

    $existing = get_posts(
        array(
            'post_type' => 'page',
            'name' => 'california-privacy-policy',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'no_found_rows' => true,
        )
    );

    if (!empty($existing)) {
        return;
    }

    status_header(200);
    nocache_headers();
    get_header();
    st_render_california_privacy_policy_main('California Privacy Policy (CCPA)', 'class="post"');
    get_footer();
    exit;
}

add_action('template_redirect', 'st_california_privacy_policy_maybe_virtual', 0);
