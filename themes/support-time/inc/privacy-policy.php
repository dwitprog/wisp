<?php

/**
 * Privacy Policy: контент, виртуальная страница при отсутствии записи в БД,
 * автосоздание страницы при активации темы / заходе в админку.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return string
 */
function st_legal_site_url(): string
{
    $home = home_url('/');
    if ($home && !is_wp_error($home)) {
        return untrailingslashit($home);
    }

    return 'https://complexwisps.com';
}

/**
 * @return string
 */
function st_privacy_policy_site_url(): string
{
    return st_legal_site_url();
}

/**
 * Разметка основного блока Privacy Policy.
 *
 * @param string $title Заголовок H1.
 * @param string $article_attributes Атрибуты тега article.
 */
function st_render_privacy_policy_main(string $title, string $article_attributes = 'class="post"'): void
{
    $site_url = st_privacy_policy_site_url();
    $terms_url = $site_url . '/terms-of-use/';
    $privacy_url = $site_url . '/privacy-policy/';
    $contacts_url = $site_url . '/contacts/';
    $privacy_email = 'privacy@complexwisps.com';
    $privacy_mailto = 'mailto:' . $privacy_email;
    $phone_display = '+1 971 534 7250';
    $phone_tel = 'tel:+19715347250';
    $california_privacy_url = $site_url . '/california-privacy-policy/';
    ?>
<main id="main" class="site-main page-h1">
    <div class="container">
        <h1><?php echo esc_html($title); ?></h1>
        <article <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $article_attributes;
        ?>>
            <p><strong>Last reviewed:</strong> February 10, 2026.</p>

            <p>
                WispsMedia LLC, an Oregon limited liability company (&ldquo;Company&rdquo;, &ldquo;we&rdquo;, &ldquo;our&rdquo;, or &ldquo;us&rdquo;)
                respect your privacy and are committed to protecting it through our compliance with this policy. This policy
                describes how we collect, process, retain, and disclose personal data about you when providing services to you
                through our websites, products, and services that link to this policy (our &ldquo;Services&rdquo;) and our practices
                for using, maintaining, protecting, and disclosing that information.
            </p>

            <p>This policy applies only to information we collect:</p>
            <ul>
                <li>Through the Services.</li>
                <li>In communications, including email, text, chat, and other electronic messages, between you and the Services.</li>
                <li>When you interact with our advertising and applications (including mobile apps) on third-party websites and services, if those applications or advertising include links to this policy.</li>
            </ul>

            <p>It does not apply to information collected by:</p>
            <ul>
                <li>Us through any other means, including on any other website operated by Company or any third party that does not link to this policy; or</li>
                <li>Any third party, including through any application or content (including advertising) that may link to or be accessible from or through the Services.</li>
            </ul>

            <p>
                We may provide additional or different privacy policies that are specific to certain features, services, or activities.
            </p>

            <p>
                Please read this policy carefully to understand our policies and practices regarding your information and how we treat it.
                By interacting with our Services or providing us with your information, you agree to the collection, use, and sharing of your
                information as described in this privacy policy. This policy may change from time to time (see Changes to Our Privacy Policy).
                Your continued use of the Services after we make changes as described here is deemed to be acceptance of those changes, so please
                check the policy periodically for updates.
            </p>

            <h2>Children&rsquo;s and Minors&rsquo; Data</h2>
            <p>
                Our Services are not intended for, and we do not knowingly collect any personal data from, children under the age of 18.
                If we learn we have collected or received personal data from a child under 18 years old without verification of parental consent,
                we will delete that information.
            </p>

            <h2>Residents of the EU, European Economic Area, or the United Kingdom</h2>
            <p>
                If you are a resident of the European Union, European Economic Area (EEA), or the United Kingdom, this site is not directed at you,
                and you should not provide personal information, as our data protection practices do not adhere to the GDPR. The Services are not
                directed at residents of the European Union, European Economic Area (EEA), and the United Kingdom.
            </p>

            <h2>The Personal Data That We Collect or Process</h2>
            <p>
                &ldquo;Personal data&rdquo; is information that identifies, relates to, or describes, directly or indirectly, you as an individual,
                such as your name, email address, telephone number, home address, or payment information (for example, account information such as
                name, postal address, and email address, credit card number, or any other identifier we may use to contact you online or offline).
            </p>

            <p>The types and categories of personal data we collect or process include:</p>
            <ul>
                <li>Account and contact information, including name, address (such as home address, work address, or other address), email address, phone number, and other contact information you provide us.</li>
                <li>Payment information, including credit card or debit card information and information about the payment methods and services (such as PayPal or Venmo) you use in connection with the Services.</li>
                <li>Account history, including information about your subscription, account, transactions, purchases, order history, or discounts.</li>
                <li>Location information, including general geographic location such as country, state or province, or city.</li>
                <li>Device information, including your IP address, device identifiers, operating system and version, preferred language, hardware identifiers, browser type and settings, and other device information.</li>
            </ul>

            <p>
                If you are a California resident, to access our supplemental California privacy statement, visit
                <a href="<?php echo esc_url($california_privacy_url); ?>">our California privacy notice</a>.
            </p>

            <p>We also collect:</p>
            <ul>
                <li><strong>Statistics or aggregated information.</strong> Statistical or aggregated data does not directly identify a specific person, but we may derive non-personal statistical or aggregated data from personal data. For example, we may aggregate personal data to calculate the percentage of users accessing a specific Services feature.</li>
                <li><strong>Technical information.</strong> Technical information includes information about your internet connection and usage details about your interactions with the Services, such as clickstream information to, through, and from our Services (including date and time), products that you view or search for; page response times, download errors, length of your visits to certain pages, page interaction information (such as scrolling, clicks, and mouse-overs), or methods used to browse away from a page.</li>
            </ul>

            <p>
                If we combine or connect non-personal statistical or technical data with personal data so that it directly or indirectly identifies
                an individual, we treat the combined information as personal information.
            </p>

            <h2>How We Collect Your Personal and Other Data</h2>
            <h3>You Provide Information to Us</h3>
            <p>We collect information about you when you interact with our Services, such as when you place an order or make a request.</p>

            <h3>Automatically Through Our Services</h3>
            <p>
                As you navigate through and interact with our Services, we may use automatic data collection technologies to collect information that
                may include personal data. Information collected automatically may include usage details, IP addresses, operating system, and browser type,
                and information collected through cookies, web beacons, and other tracking technologies, including details of your interactions with our
                Services, such as traffic data, location data, logs, and other communication data, and which resources and Services features that you
                access and use.
            </p>
            <p>Using automatic collection technologies helps us to improve our Services and to deliver a better and more personalized experience.</p>
            <p>The technologies we use for this automatic data collection may include:</p>
            <ul>
                <li><strong>Cookies.</strong> A cookie is a small file placed on your device when you interact with the Services. You may refuse to accept or disable cookies by activating the appropriate setting on your browser or device. However, if you select this setting, you may be unable to access certain features of the Services.</li>
                <li><strong>Web Beacons.</strong> Some parts of the Services and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those parts or opened an email and for other related statistics (for example, recording the popularity of certain content and verifying system and server integrity).</li>
            </ul>
            <p>
                To the extent any of these automated technologies are considered a personal data sale, targeted advertising, or profiling, under applicable
                laws, depending on where you live, you may opt out from use of these automated technologies for such uses by sending a request via the
                contact portal on our website (<a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html($site_url); ?></a>) or via email to
                <a href="<?php echo esc_url($privacy_mailto); ?>"><?php echo esc_html($privacy_email); ?></a>.
                Please note that some Services features may be unavailable as a result.
            </p>
            <p>When you interact with the Services, there are third parties that may use automatic collection technologies to collect information about you or your device. These third parties may include:</p>
            <ul>
                <li>Advertisers, ad networks, and ad servers.</li>
                <li>Analytics companies.</li>
                <li>Your device manufacturer.</li>
                <li>Your internet or mobile service provider.</li>
            </ul>
            <p>
                These third parties may use tracking technologies to collect information about you when you use the Services. The information they collect
                may be associated with your personal data or they may collect information, including personal data, about your online activities over time
                and across different websites, apps, platforms, and other online services. They may use this information to provide you with interest-based
                (behavioral) advertising or other targeted content.
            </p>
            <p>
                We do not control these third parties&rsquo; tracking technologies or how they may be used. If you have any questions about an advertisement
                or other targeted content, you should contact the responsible provider directly.
            </p>

            <h2>How We Use Your Information</h2>
            <p>We use information that we collect about you or that you provide to us, including any personal data, to:</p>
            <ul>
                <li>Provide you with the Services and any contents, features, information, products, or services that we make available through the Services.</li>
                <li>Fulfill and manage orders and requests.</li>
                <li>Fulfill any other purpose for which you provide it.</li>
                <li>Improve our Services, including by analyzing your information and creating aggregated data derived from your information to develop, maintain, analyze, improve, optimize, measure, and report on our Services and their features and how users interact with them.</li>
                <li>Promote our Services, business, and offerings by publishing advertising on our own Services.</li>
                <li>Conduct our obligations and enforce our rights arising from any contracts entered into between you and us, including for billing and collection.</li>
                <li>Notify you when Services updates are available and about changes to any products or services we offer or provide though them.</li>
                <li>In any other way we may describe when you provide the information.</li>
                <li>For any other purpose with your consent.</li>
            </ul>
            <p>The usage information we collect, whether connected to your personal data or not, helps us improve our Services and deliver a better and more personalized experience by enabling us to:</p>
            <ul>
                <li>Estimate our audience sizes and usage patterns.</li>
                <li>Store information about your preferences, allowing us to customize the Services according to your individual needs and interests.</li>
                <li>Recognize you when you return to our Services.</li>
            </ul>

            <h2>Who We Disclose Your Information To</h2>
            <p>We may disclose aggregated information about our users, and information that does not identify any individual, without restriction.</p>
            <p>We may also disclose personal data that we collect or you provide as described in this privacy policy:</p>
            <ul>
                <li>To our subsidiaries and affiliates.</li>
                <li>To contractors, service providers, and other third parties we use to support our organization.</li>
                <li>To a buyer or other successor in the event of a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of WispsMedia LLC&rsquo;s assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which personal data held by WispsMedia LLC is among the assets transferred.</li>
                <li>To fulfill the purpose for which you provide it.</li>
                <li>For any other purpose disclosed by us when you provide the information.</li>
                <li>With your consent.</li>
            </ul>
            <p>We may also disclose your personal data:</p>
            <ul>
                <li>To comply with any court order, law, or legal process, including to respond to any government or regulatory request.</li>
                <li>To enforce or apply our <a href="<?php echo esc_url($terms_url); ?>">Terms of Use</a> and other agreements, including for billing and collection purposes.</li>
                <li>If we believe disclosure is necessary or appropriate to protect the rights, property, or safety of our organization, our customers, or others.</li>
            </ul>
            <p>The categories of personal data we may disclose include:</p>
            <ul>
                <li>Contact information.</li>
                <li>Payment information.</li>
                <li>Information about your purchases.</li>
                <li>Location information, including general geographic location.</li>
                <li>Device information.</li>
                <li>Content and information you elect to provide to us.</li>
            </ul>

            <h2>Your Rights and Choices About Your Information</h2>
            <p>This section describes mechanisms you can use to control certain uses and disclosures of your information and rights you may have under state law, depending on where you live.</p>
            <p><strong>Advertising, marketing, cookies, and other tracking technologies choices:</strong></p>
            <ul>
                <li><strong>Cookies and Other Tracking Technologies.</strong> You can set your browser to refuse all or some browser cookies or other tracking technology files, or to alert you when these files are being sent. If you disable or refuse cookies or similar tracking files, some Services features may be inaccessible or not function properly. Some browsers include a &ldquo;Do Not Track&rdquo; (DNT) setting that can send a signal to the online services you visit indicating you do not wish to be tracked.</li>
            </ul>
            <p><strong>Location data choices:</strong></p>
            <ul>
                <li><strong>Location Data.</strong> You can choose whether or not to allow the Services to collect and use real-time information about your device&rsquo;s location through the device&rsquo;s privacy settings. If you block the use of location information, some Services features may become inaccessible or not function properly.</li>
            </ul>

            <h2 id="state-privacy-rights">Your State Privacy Rights</h2>
            <p>Depending on your state of residency, you may have certain rights related to your personal data, including:</p>
            <ul>
                <li><strong>Access and Data Portability.</strong> You may confirm whether we process your personal data and access a copy of the personal data we process. To the extent feasible and required by state law, depending on your state, data will be provided in a portable format. Depending on your state, you may have the right to receive additional information and it will be included in the response to your access request.</li>
                <li><strong>Correction.</strong> You may request that we correct inaccuracies in your personal data that we maintain, taking into account the information&rsquo;s nature and processing purpose.</li>
                <li><strong>Deletion.</strong> You may request that we delete personal data about you that we maintain, subject to certain exception under applicable law.</li>
                <li><strong>Opt Out of Using Personal Data for Targeted Advertising, Profiling, and Sales.</strong> You may request that we do not use your personal data for these purposes.</li>
            </ul>
            <p>
                <strong>Important:</strong> The exact scope of these rights vary by state. There are also several exceptions where we may not have an obligation to fulfill your request.
            </p>
            <p>
                To exercise any of these rights, please do so by sending a request via the contact portal on our website
                (<a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html($site_url); ?></a>) or via email to
                <a href="<?php echo esc_url($privacy_mailto); ?>"><?php echo esc_html($privacy_email); ?></a>.
                To appeal a decision regarding a consumer rights request submit an appeal request via the contact portal on our website
                (<a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html($site_url); ?></a>) or via email to
                <a href="<?php echo esc_url($privacy_mailto); ?>"><?php echo esc_html($privacy_email); ?></a>.
            </p>
            <p>
                Some browsers and browser extensions support the Global Privacy Control (&ldquo;GPC&rdquo;) that can send a signal to process your request to opt out
                from certain types of data processing, including data &ldquo;sales&rdquo; as defined under certain laws. When we detect such a signal, we will make reasonable
                efforts to respect your choices indicated by a GPC setting as required by applicable law.
            </p>
            <p>
                If you are a California resident, additional information applies to you. To access our supplemental California privacy statement and learn more
                about California residents&rsquo; privacy rights, visit
                <a href="<?php echo esc_url($california_privacy_url); ?>">our California privacy notice</a>.
            </p>

            <h2>How We Protect Your Personal Data</h2>
            <p>
                We use commercially reasonable administrative, physical, and technical measures designed to protect your personal data from accidental loss
                or destruction and from unauthorized access, use, alteration, and disclosure. However, no website, mobile application, system, electronic storage,
                or online service is completely secure, and we cannot guarantee the security of your personal data transmitted to, through, using, or in connection
                with the Services. In particular, email, texts, and chats sent to or from the Services may not be secure, and you should carefully decide what
                information you send to us via such communications channels. Any transmission of personal data is at your own risk.
            </p>
            <p>
                The safety and security of your information also depends on you. You are responsible for taking steps to protect your personal data against
                unauthorized use, disclosure, and access.
            </p>

            <h2>How We Retain Your Personal Data</h2>
            <p>
                We keep the categories of personal data described in this policy for as long as reasonably necessary to fulfill the purposes described or for as
                otherwise legally permitted or required, such as maintaining the Services, operating our organization, complying with our legal obligations,
                resolving disputes, and for safety, security, and fraud prevention. This means that we consider our legal and business obligations, potential risks
                of harm, and nature of the information when deciding how long to retain personal data. At the end of the retention period, personal data will be
                deleted, destroyed, or deidentified.
            </p>
            <p>
                If you are a California resident, visit
                <a href="<?php echo esc_url($california_privacy_url); ?>">our California privacy notice</a>
                for more information about the retention periods that apply to the personal data categories we collect.
            </p>

            <h2>Changes to Our Privacy Policy</h2>
            <p>
                We may update this policy from time to time, and we will provide notice of any such changes to the policy as required by law. The date the privacy
                policy was last updated is identified at the top of the page. We will notify you of changes to this policy by updating the &ldquo;last updated&rdquo; date
                and posting the updated policy on the Services. We may email or otherwise communicate reminders about this policy, but you should check our Services
                periodically to see the current policy and any changes we have made to it.
            </p>

            <h2>Contact Information</h2>
            <p>To exercise your rights or ask questions or comment about this privacy policy or our privacy practices, contact us at:</p>
            <p>
                <a href="<?php echo esc_url($privacy_mailto); ?>"><?php echo esc_html($privacy_email); ?></a><br>
                or via our toll-free number: <a href="<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_display); ?></a>
            </p>
            <p>
                You may also reach us through our
                <a href="<?php echo esc_url($contacts_url); ?>">Contacts</a> page at
                <a href="<?php echo esc_url($contacts_url); ?>"><?php echo esc_html($contacts_url); ?></a>.
            </p>
        </article>
    </div>
</main>
    <?php
}

/**
 * Создаёт страницу privacy-policy при возможности (права publish_pages).
 */
function st_ensure_privacy_policy_page_callback(): void
{
    if (wp_installing() || wp_doing_ajax()) {
        return;
    }

    if (!current_user_can('publish_pages')) {
        return;
    }

    $slug = 'privacy-policy';
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
            'post_title' => 'Privacy Policy',
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

add_action('after_switch_theme', 'st_ensure_privacy_policy_page_callback');
add_action('admin_init', 'st_ensure_privacy_policy_page_callback');

/**
 * Если записи страницы нет, отдаём контент с кодом 200 (без 404).
 */
function st_privacy_policy_maybe_virtual(): void
{
    if (is_admin()) {
        return;
    }

    $path = isset($_SERVER['REQUEST_URI']) ? (string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    $path = trim($path, '/');
    if ($path !== 'privacy-policy') {
        return;
    }

    $existing = get_posts(
        array(
            'post_type' => 'page',
            'name' => 'privacy-policy',
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
    st_render_privacy_policy_main('Privacy Policy', 'class="post"');
    get_footer();
    exit;
}

add_action('template_redirect', 'st_privacy_policy_maybe_virtual', 0);
