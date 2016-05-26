<modification>
	<id><![CDATA[Customer Verification]]></id>
	<version><![CDATA[1.0.0]]></version>
	<vqmver><![CDATA[2.0]]></vqmver>
	<author><![CDATA[DrMaglev - http://grasssupermarket.com]]></author>
	<file name="catalog/language/english/mail/customer.php">
		<operation error="skip">
			<search position="after" error="log"><![CDATA[INSERT TEXT EMAIL VERIFICATION HERE]]></search>
			<add><![CDATA[$_['text_email_verification'] = 'Your account has now been created, but you must verify your e-mail address in our system. Please click the link below to activate your account. If the link does not work, try copying the link manually to your browser\'s address field and press Enter.';
]]></add>
		</operation>
	</file>
	<file name="catalog/model/account/customer.php">
		<operation error="skip">
			<search position="before" error="log"><![CDATA[$this->language->load('mail/customer');]]></search>
			<add><![CDATA[list($usec, $sec) = explode(' ', microtime());
            srand((float) $sec + ((float) $usec * 100000));
            $verification_code = md5($customer_id . ':' . rand());
            $this->db->query("DELETE FROM ".DB_PREFIX."customer_verification WHERE customer_id = '".(int)$customer_id."'");
            $this->db->query("INSERT INTO ".DB_PREFIX."customer_verification SET customer_id = '".(int)$customer_id."', verification_code = '".$verification_code."'");
            $verification_link = $this->url->link('account/verification') . '&v=' . $verification_code . '&u=' . (int)$customer_id;
        ]]></add>
		</operation>
		
		<operation>
			<search position="replace" error="skip"><![CDATA[$message .= $this->language->get('text_approval') . "\n";]]></search>
			<add><![CDATA[            $message .= $this->language->get('text_email_verification') . "\n\n";
            $message .= $verification_link . "\n\n";
]]></add>
		</operation>
		
		<operation>
		<search position = "replace" error="skip"><![CDATA[$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";]]></search>
		<add><![CDATA[/*$message .= $this->url->link('account/login', '', 'SSL') . "\n\n"; */
]]></add>
		</operation>
	</file>
	
	<file name="catalog/language/english/account/success.php">
		<operation error="skip">
			<search position="replace" error="log"><![CDATA[$_['heading_title'] = 'Your Account Has Been Created!';]]></search>
			<add><![CDATA[$_['heading_title'] = 'Please verify your email'; ]]></add>
		</operation>
		<operation>
			<search position="replace"><![CDATA[$_['text_approval'] = '<p>Thank you for registering with %s!</p><p>You will be notified by email once your account has been activated by the store owner.</p><p>If you have ANY questions about the operation of this online shop, please <a href="%s">contact the store owner</a>.</p>';     ]]></search>
			<add><![CDATA[$_['text_approval'] = '<p>Thank you for registering with %s!</p><p>Your account has now been created, but for your security, you must first verify the e-mail address you registered with.</p></p>A verification email has been sent to the email you provided.</p><p> <b>If you haven\'t received it, please <font color="red" size="3">check your JUNK MAIL or SPAM Folder </font> and add this domain name to your safe list to avoid missing future communications</b>.</p>';
            ]]></add>
		</operation>
	</file>
</modification>
