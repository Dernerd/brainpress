<?php

class BrainPress_Helper_Setting_Email {

	public static function get_defaults( $context = false ) {
		add_filter( 'brainpress_admin_setting_before_top_save', array( __CLASS__, 'add_buttons' ), 10, 2 );
		$defaults = apply_filters(
			'brainpress_default_email_settings',
			array(
				BrainPress_Helper_Email::BASIC_CERTIFICATE => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => BrainPress_View_Admin_Setting_BasicCertificate::default_email_subject(),
					'content' => BrainPress_View_Admin_Setting_BasicCertificate::default_email_content(),
					'auto_email' => true,
				),
				BrainPress_Helper_Email::REGISTRATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Registrationsstatus', 'brainpress' ),
					'content' => self::_registration_email(),
				),
				BrainPress_Helper_Email::ENROLLMENT_CONFIRM => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'EinschreibungsbestÃ¤tigung', 'brainpress' ),
					'content' => self::_enrollment_confirmation_email(),
				),
				BrainPress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Neue Einschreibung in Deinen Kurs', 'brainpress' ),
					'content' => self::_instructor_enrollment_notification_email(),
				),
				BrainPress_Helper_Email::COURSE_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Einladung zu einem Kurs', 'brainpress' ),
					'content' => self::_course_invitation_email(),
				),
				BrainPress_Helper_Email::COURSE_INVITATION_PASSWORD => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Einladung zu einem Kurs (Psss ... nur fÃ¼r ausgewÃ¤hlte)', 'brainpress' ),
					'content' => self::_course_invitation_passcode_email(),
				),
				BrainPress_Helper_Email::INSTRUCTOR_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => sprintf( __( 'Einladung zum Kursleiter bei %s', 'brainpress' ), get_option( 'blogname' ) ),
					'content' => self::_instructor_invitation_email(),
				),
				BrainPress_Helper_Email::FACILITATOR_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => sprintf( __( 'Einladung zum Moderator bei %s', 'brainpress' ), get_option( 'blogname' ) ),
					'content' => self::_facilitator_invitation_email(),
				),
				BrainPress_Helper_Email::NEW_ORDER => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'BestellbestÃ¤tigung', 'brainpress' ),
					'content' => self::_new_order_email(),
				),
				BrainPress_Helper_Email::COURSE_START_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Benachrichtigung Ã¼ber Kursstart', 'brainpress' ),
					'content' => self::course_start_defaults(),
				),
				BrainPress_Helper_Email::DISCUSSION_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Diskussionsbenachrichtigung', 'brainpress' ),
					'content' => self::discussion_defaults(),
				),
				BrainPress_Helper_Email::UNIT_STARTED_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( '[UNIT_TITLE] ist nun verfÃ¼gbar', 'brainpress' ),
					'content' => self::unit_started_defaults(),
				),
				BrainPress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Neues Feedback', 'brainpress' ),
					'content' => self::instructor_feedback_module_defaults(),
				),
			)
		);

		if ( $context && isset( $defaults[ $context ] ) ) {
			return $defaults[ $context ];
		} else {
			return $defaults;
		}
	}

	public static function get_settings_sections() {
		$basic_certificate_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::BASIC_CERTIFICATE,
			array(
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'COURSE_ADDRESS' => '',
				'FIRST_NAME' => '',
				'LAST_NAME' => '',
				'COURSE_NAME' => '',
				'COMPLETION_DATE' => '',
				'CERTIFICATE_NUMBER' => '',
				'CERTIFICATE_URL' => '',
				'UNIT_LIST' => '',
			),
			null
		);
		$registration_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::REGISTRATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'STUDENT_USERNAME' => '',
				'STUDENT_PASSWORD' => '',
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
			),
			null
		);
		$enrollment_confirm = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::ENROLLMENT_CONFIRM,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'COURSE_ADDRESS' => '',
			),
			null
		);
		$instructor_enrollment_notification = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'COURSE_TITLE' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_ADMIN_ADDRESS' => '',
				'COURSE_STUDENTS_ADMIN_ADDRESS' => '',
				'WEBSITE_NAME' => '',
				'WEBSITE_ADDRESS' => ''
			)
		);
		$course_invitation_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::COURSE_INVITATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'COURSE_NAME' => '',
				'COURSE_EXCERPT' => '',
				'COURSE_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'PASSCODE' => '',
			),
			null
		);
		$instructor_invitation_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::INSTRUCTOR_INVITATION,
			array(
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'INSTRUCTOR_EMAIL' => '',
				'CONFIRMATION_LINK' => '',
				'COURSE_NAME' => '',
				'COURSE_EXCERPT' => '',
				'COURSE_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'WEBSITE_NAME' => '',
			),
			null
		);
		$course_start_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::COURSE_START_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_OVERVIEW' => '',
				'BLOG_NAME' => '',
				'WEBSITE_ADDRESS' => '',
				'UNSUBSCRIBE_LINK' => '',
			)
		);
		$discussion_fields = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::DISCUSSION_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_OVERVIEW' => '',
				'BLOG_NAME' => '',
				'WEBSITE_ADDRESS' => '',
				'COMMENT_MESSAGE' => '',
				'COURSE_DISCUSSION_ADDRESS' => '',
				'UNSUBSCRIBE_LINK' => '',
				'COMMENT_AUTHOR' => '',
			)
		);
		$units_started = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::UNIT_STARTED_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'UNIT_TITLE' => '',
				'UNIT_OVERVIEW' => '',
				'UNIT_ADDRESS' => '',
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'UNSUBSCRIBE_LINK' => '',
			)
		);
		$instructor_module_feedback = apply_filters( 'brainpress_fields_' . BrainPress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'CURRENT_UNIT' => '',
				'CURRENT_MODULE' => '',
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'INSTRUCTOR_FEEDBACK' => '',
				'COURSE_GRADE' => '',
			)
		);
		$basic_certificate_fields = array_keys( $basic_certificate_fields );
		$registration_fields = array_keys( $registration_fields );
		$enrollment_confirm = array_keys( $enrollment_confirm );
		$instructor_enrollment_notification = array_keys( $instructor_enrollment_notification );
		$course_invitation_fields = array_keys( $course_invitation_fields );
		$instructor_invitation_fields = array_keys( $instructor_invitation_fields );
		$course_start_fields = array_keys( $course_start_fields );
		$discussion_fields = array_keys( $discussion_fields );
		$units_started = array_keys( $units_started );
		$instructor_module_feedback = array_keys( $instructor_module_feedback );

		$defaults = apply_filters(
			'brainpress_default_email_settings_sections',
			array(
				BrainPress_Helper_Email::BASIC_CERTIFICATE => array(
					'title' => __( 'E-Mail des Basiszertifikats', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r E-Mails bei Verwendung der grundlegenden ZertifikatfunktionalitÃ¤t (nach Abschluss des Kurses).', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $basic_certificate_fields ),
					'order' => 7,
				),
				BrainPress_Helper_Email::REGISTRATION => array(
					'title' => __( 'Benutzerregistrierungs-E-Mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r einen E-Mail-Studenten erhÃ¤ltst Du bei der Registrierung des Kontos.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $registration_fields ),
					'order' => 1,
				),
				BrainPress_Helper_Email::ENROLLMENT_CONFIRM => array(
					'title' => __( 'E-Mail zur BestÃ¤tigung der Kurseinschreibung', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r einen E-Mail-Studenten erhÃ¤ltst Du bei der Einschreibung.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $enrollment_confirm ),
					'order' => 2,
				),
				BrainPress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION => array(
					'title' => __( 'Registrierungsbenachrichtigung fÃ¼r Kursleiter-E-Mail', 'brainpress' ),
					'description' => __( 'Die Einstellungen fÃ¼r einen E-Mail-Kursleiter werden angezeigt, wenn sich ein neuer Student einschreibt.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $instructor_enrollment_notification ),
					'order' => 3,
				),
				BrainPress_Helper_Email::COURSE_INVITATION => array(
					'title' => __( 'Studenteneinladung zu einer Kurs-E-Mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r einen E-Mail-Studenten erhÃ¤ltst Du, wenn Du eine Einladung zu einem Kurs erhÃ¤ltst.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $course_invitation_fields ),
					'order' => 3,
				),
				BrainPress_Helper_Email::COURSE_INVITATION_PASSWORD => array(
					'title' => __( 'Studenteneinladung zu einer Kurs-E-Mail (mit Passcode)', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r einen E-Mail-Studenten erhÃ¤ltst Du, wenn Du eine Einladung (mit Passcode) zu einem Kurs erhÃ¤ltst.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $course_invitation_fields ),
					'order' => 4,
				),
				BrainPress_Helper_Email::INSTRUCTOR_INVITATION => array(
					'title' => __( 'Kursleiter Einladung Email', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r eine E-Mail, die ein Kursleiter nach Erhalt einer Einladung erhÃ¤lt.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $instructor_invitation_fields ),
					'order' => 5,
				),
				BrainPress_Helper_Email::FACILITATOR_INVITATION => array(
					'title' => __( 'Einladung des Moderators Email', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r eine E-Mail, die ein Moderator nach Erhalt einer Einladung erhÃ¤lt.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $instructor_invitation_fields ),
					'order' => 5,
				),
				BrainPress_Helper_Email::NEW_ORDER => array(
					'title' => __( 'Neue Bestellung E-mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r einen E-Mail-Studenten erhÃ¤ltst Du bei der Bestellung.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: CUSTOMER_NAME, BLOG_NAME, LOGIN_ADDRESS, COURSES_ADDRESS, WEBSITE_ADDRESS, COURSE_ADDRESS, ORDER_ID, ORDER_STATUS_URL', 'brainpress' ),
					'order' => 6,
				),
				BrainPress_Helper_Email::COURSE_START_NOTIFICATION => array(
					'title' => __( 'Kursbenachrichtigung E-mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r eine E-Mail, die zu Beginn eines Kurses an die Studenten gesendet werden soll.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $course_start_fields ),
					'order' => 7,
				),
				BrainPress_Helper_Email::DISCUSSION_NOTIFICATION => array(
					'title' => __( 'Diskussionsbenachrichtigung E-mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r eine E-Mail, die an Studenten und Kursleiter gesendet werden soll.', 'brainpress' ),
					'content_help_text' => __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $discussion_fields ),
					'order' => 7,
				),
				BrainPress_Helper_Email::UNIT_STARTED_NOTIFICATION => array(
					'title' => __( 'Kurseinheit gestartet E-mail', 'brainpress' ),
					'description' => __( 'Einstellungen fÃ¼r eine E-Mail, die an Studenten gesendet werden soll, wenn eine Einheit gestartet wurde.', 'brainpress' ),
					'content_help_text' => sprintf( __( '* Du kannst %s Mail-Token fÃ¼r Deine Betreffzeile verwenden. ', 'brainpress' ), 'UNIT_TITLE' ) .
						__( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $units_started ),
					'order' => 8,
				),
				BrainPress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION => array(
					'title' => __( 'Kursleiter Feedback', 'brainpress' ),
					'description' => __( 'Vorlage zum Senden von Feedback von Kursleitern an Studenten.', 'brainpress' ),
					'content_help_text' => sprintf( __( 'Diese Codes werden durch tatsÃ¤chliche Daten ersetzt: ', 'brainpress' ) . implode( ', ', $instructor_module_feedback ) ),
					'order' => 9,
				),
			)
		);

		return $defaults;
	}

	private static function _registration_email() {
		return BrainPress_Core::get_setting(
			'email/registration/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Willkommen zu %3$s!

Hier kannst Du auf Dein Profil zugreifen: %4$s

Und beginne hier mit der Erkundung unserer Kurse: %5$s

Die besten WÃ¼nsche,
Das %6$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'BLOG_NAME',
				'<a href="LOGIN_ADDRESS">LOGIN_ADDRESS</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _enrollment_confirmation_email() {
		return BrainPress_Core::get_setting(
			'email/enrollment_confirm/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Herzliche GlÃ¼ckwÃ¼nsche! Du hast Dich fÃ¼r "%3$sâ eingeschrieben.

Du kannst die Kurse, fÃ¼r die Du dich eingeschrieben hast, hier einsehen: %4$s.

Und entdecke andere Kurse, die Dir hier zur VerfÃ¼gung stehen: %5$s

Die besten WÃ¼nsche,
Das %6$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'<a href="COURSE_ADDRESS">COURSE_TITLE</a>',
				'<a href="STUDENT_DASHBOARD">' . __( 'Dashboard', 'brainpress' ) . '</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	private static function _instructor_enrollment_notification_email() {
		return BrainPress_Core::get_setting(
			'email/instructor_enrollment_notification/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Ein neuer Student "%3$s %4$s" hat sich in Deinen Kurs "%5$s" eingeschrieben.

Du kannst alle in diesem Kurs eingeschriebenen Studenten hier verwalten: %6$s

Die besten WÃ¼nsche,
Das %7$s Team', 'brainpress' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'<a href="COURSE_ADMIN_ADDRESS">COURSE_TITLE</a>',
				'<a href="COURSE_STUDENTS_ADMIN_ADDRESS">COURSE_STUDENTS_ADMIN_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	private static function _course_invitation_email() {
		return BrainPress_Core::get_setting(
			'email/course_invitation/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Du bist eingeladen, dich einzuschreiben: "%3$s"

Hier einige weitere Informationen zum Kurs:

%4$s

Auf der Kursseite findest Du eine detaillierte Ãbersicht: %5$s

Wenn Du Fragen hast, kannst Du dich gerne an uns wenden!

Die besten WÃ¼nsche,
Das %6$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'COURSE_EXCERPT',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _course_invitation_passcode_email() {
		return BrainPress_Core::get_setting(
			'email/course_invitation_password/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Du bist eingeladen, dich einzuschreiben: "%3$s"

Dieser Kurs steht nur Teilnehmern zur VerfÃ¼gung, die einen Passcode haben.

Dein Passcode ist: %7$s

Hier einige weitere Informationen zum Kurs:

%4$s

Auf der Kursseite findest Du eine detaillierte Ãbersicht: %5$s

Wenn Du Fragen hast, kannst Du dich gerne an uns wenden!

Die besten WÃ¼nsche,
Das %6$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'COURSE_EXCERPT',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>',
				'PASSCODE'
			)
		);
	}

	private static function _instructor_invitation_email() {
		return BrainPress_Core::get_setting(
			'email/instructor_invitation/content',
			sprintf(
				__('Hi %1$s %2$s,

Herzliche GlÃ¼ckwÃ¼nsche! Du wurdest eingeladen, Kursleiter fÃ¼r den Kurs zu werden: %3$s

Klicke zur BestÃ¤tigung auf den unten stehenden Link:

%4$s

Wenn Du noch keinen Benutzernamen erhalten hast, musst Du einen erstellen.

%5$s

Die besten WÃ¼nsche,
Das %5$s Team', 'brainpress' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'COURSE_NAME',
				'<a href="CONFIRMATION_LINK">CONFIRMATION_LINK</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _facilitator_invitation_email() {
		return BrainPress_Core::get_setting(
			'email/facilitator_invitation/content',
			sprintf(
				__('Hi %1$s %2$s,

Herzliche GlÃ¼ckwÃ¼nsche! Du wurdest eingeladen, %3$s als Moderator beizutreten.

Klicke zur BestÃ¤tigung auf den unten stehenden Link:

%4$s

Wenn Du noch keinen Benutzernamen erhalten hast, musst Du einen erstellen. Das kannst Du hier machen:

%5$s

Die besten WÃ¼nsche,
Das %5$s Team', 'brainpress' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'COURSE_NAME',
				'<a href="CONFIRMATION_LINK">CONFIRMATION_LINK</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _new_order_email() {
		return BrainPress_Core::get_setting(
			'email/new_order/content',
			sprintf(
				__( 'Vielen Dank fÃ¼r Deine Bestellung %1$s,

Deine Bestellung fÃ¼r den Kurs "%2$s" ist eingegangen!

Bitte beziehe Dich bei der Kontaktaufnahme auf Deine Bestellnummer (ORDER_ID).

Den aktuellen Status Deiner Bestellung kannst Du hier verfolgen: ORDER_STATUS_URL

Die besten WÃ¼nsche,
Das %5$s Team', 'brainpress' ),
				'CUSTOMER_NAME',
				'<a href="COURSE_ADDRESS">COURSE_TITLE</a>',
				'<a href="STUDENT_DASHBOARD">' . __( 'Dashboard', 'brainpress' ) . '</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'BLOG_NAME'
			)
		);
	}

	public static function course_start_defaults() {
		return BrainPress_Core::get_setting(
			'email/course_start/content',
			sprintf(
				__( 'Hi %1$s,

Dein Kurs %2$s hat begonnen!

Du kannst das Kursmaterial hier einsehen:

%3$s

Die besten WÃ¼nsche,
Das %4$s Team', 'brainpress' ),
				'FIRST_NAME',
				'COURSE_NAME',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function discussion_defaults() {
		return BrainPress_Core::get_setting(
			'email/discussion_notification/content',
			sprintf(
				__( 'Ein neuer Kommentar wurde %1$s hinzugefÃ¼gt:

%2$s

Die besten WÃ¼nsche,
Das %3$s Team', 'brainpress' ),
				'COURSE_NAME',
				'COMMENT_MESSAGE',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function unit_started_defaults() {
		return BrainPress_Core::get_setting(
			'email/unit_started/content',
			sprintf(
				__( 'Hallo %1$s,

%2$s von %3$s ist nun verfÃ¼gbar.

Du kannst Dein Lernen fortsetzen, indem Du auf den folgenden Link klickst:
%4$s

Die besten WÃ¼nsche,
Das %5$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'UNIT_TITLE',
				'COURSE_NAME',
				'UNIT_ADDRESS',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function instructor_feedback_module_defaults() {
		return BrainPress_Core::get_setting(
			'email/instructor_feedback_module/content',
			sprintf( __(
				'Hi %1$s %2$s,

Ein neues Feedback gibt Dein Instruktor unter %3$s in %4$s im %5$s

%6$s sagt
%7$s

Die besten WÃ¼nsche,
Das %8$s Team', 'brainpress' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'CURRENT_UNIT',
				'CURRENT_MODULE',
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'INSTRUCTOR_FEEDBACK',
				'WEBSITE_ADDRESS'
			)
		);
	}

	/**
	 * Add buttons: fold and unfold.
	 *
	 * @since 2.0.0
	 *
	 * @param string $content Current content to filter.
	 * @param string $active Current tab key.
	 * @return string Content after filter.
	 */
	public static function add_buttons( $content, $active ) {
		if ( 'email' != $active ) {
			return $content;
		}
		$content .= sprintf(
			'<input type="button" class="button %s disabled" value="%s" /> ',
			'hndle-items-fold',
			esc_attr__( 'Falte alle', 'brainpress' )
		);
		$content .= sprintf(
			'<input type="button" class="button %s" value="%s" /> ',
			'hndle-items-unfold',
			esc_attr__( 'Entfalte alle', 'brainpress' )
		);
		return $content;
	}
}
