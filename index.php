<?php

/*
*	PUBLIC FOLDER NAME
*	There should be all *.css, *.js and image files.
*	Use it only if neccesary.
*/
$public_folder = 'public';

/*
*	SYSTEM FOLDER NAME
*	The main folder of the system.
*/
$system_folder = 'system';

/*
*	APPLICATION FOLDER NAME
*	Folder where application files will be stored.
*/
$application_folder = 'application';

/* Three main paths */
// Path to public folder. Use it only if NECCESARY.
defined( 'PUBPATH' ) or define( 'PUBPATH', realpath( dirname( __FILE__ ) . '/' . $public_folder ) );
// Path to application folder.
defined( 'APPPATH' ) or define( 'APPPATH', realpath( dirname( __FILE__ ) . '/' . $application_folder ) );
// Path to system folder.
defined( 'SYSPATH' ) or define( 'SYSPATH', realpath( dirname( __FILE__ ) . '/' . $system_folder ) );

// Start session
session_start();

// Include configs
require_once( SYSPATH . '/config/config.php' );

// Getting all needed classes
function __autoload( $class )
{
	if ( file_exists( APPPATH . '/libraries/' . $class . '.php' ) )
	{
		require_once( APPPATH . '/libraries/' . $class . '.php' );
	}
	elseif ( file_exists( SYSPATH . '/libraries/' . $class . '.php' ) )
	{
		require_once( SYSPATH . '/libraries/' . $class . '.php' );
	}
	else
	{
		require_once( SYSPATH . '/libraries/database/' . $class . '.php' );
	}
}

// Create MySQL DB instance
$db = new MySQLDatabase();

// Create Validation instance
$validator = new Validation();

// Create User instance
$umanager = new UserManager( $db, $validator );

// Assuming, that user will Sign In
// and that he will create or work with tickets
$ticket = new Ticket( $db, $validator );

// Create Pagination instance
$page = new Pagination( $db, $umanager );

// Create Cache instance
$cache = new Cache( '/settings-cache.ini', APPPATH.'/cache', $db );
$appData = (array)$cache->getDataFromFile();

// Create Error instance
$error = new Error( $appData['base_url'], dirname( __FILE__ ), $config['error_log'] );

// Sign out user from system
if ( isset( $_REQUEST['sign_out'] ) && $_REQUEST['sign_out'] )
{
	$umanager->signOut();
}

// Link main page
if ( ! isset( $_REQUEST['show'] ) && ! $_REQUEST['sign_out'] )
{
	if ( isset( $_POST['signUpFormSubmit'] ) )
	{
		// Redirect to /signup/
		header( 'Location: ./signup/' );
	}
	else
	{
		if ( isset( $_POST['signInFormSubmit'] ) )
		{
			if ( $umanager->chooseSignInType( $_POST['username'], $_POST['userpass'] ) )
			{
				// If signed in successful, then redirect to main user page
				header( 'Location: ./dashboard/' );
			}
		}

		if( ! $umanager->isSignedIn() )
		{
			// Link header
			require_once( APPPATH . '/themes/' . $config['default_theme'] . '/layout/header.php' );

			// Link home page
			require_once( APPPATH . '/pages/main.php' );

			// Link footer
			require_once( APPPATH . '/themes/' . $config['default_theme'] . '/layout/footer.php' );
		}
		else
		{
			// Redirect to /dashboard/
			header( 'Location: ./dashboard/' );
		}
	}
}
elseif ( isset( $_REQUEST['show'] ) && ! empty( $_REQUEST['show'] ) )
{
	// If user signs up
	if ( isset( $_POST['signUp'] ) )
	{
		$umanager->signUp( $_POST['username'], $_POST['userpass1'], $_POST['userpass2'], $_POST['email'] );
	}

	// If user creates ticket
	if ( isset( $_POST['newTicket'] ) )
	{
		$ticket->addTicket( $_POST['ticketUrgency'], $_POST['ticketServices'], $_POST['ticketSubject'], $_POST['ticket'] );
	}

	if ( isset( $_POST['ticketClose'] ) )
	{
		$ticket->changeTicketStatus( $_REQUEST['ticket'], 2 );
	}

	// Link header
	require_once( APPPATH . '/themes/' . $config['default_theme'] . '/layout/header.php' );

	// Check does requested page exist or not
	if ( file_exists( APPPATH . '/pages/' . $_REQUEST['show'] . '.php' ) )
	{
		switch ( $_REQUEST['show'] )
		{
			// For user pages
			case 'dashboard':
			{
				if ( ! $umanager->isSignedIn() )
				{
					$error->forbidden();
				}
				else
				{
					if ( isset( $_REQUEST['method'] ) )
					{
						if( file_exists( APPPATH . '/pages/' . $_REQUEST['method'] . '.php' ) )
						{
							require_once( APPPATH . '/pages/' . $_REQUEST['method'] . '.php' );
						}
						else
						{
							$error->notFound();
						}
					}
					else
					{
						require_once( APPPATH . '/pages/' . $_REQUEST['show'] . '.php' );
					}
				}
				break;
			}
			// For non-user pages
			case 'signup':
			{
				if ( ! $umanager->isSignedIn() )
				{
					require_once( APPPATH . '/pages/' . $_REQUEST['show'] . '.php' );
				}
				else
				{
					$error->forbidden();
				}
				break;
			}
			case 'lic':
			case 'temp':
			{
				require_once( APPPATH . '/pages/' . $_REQUEST['show'] . '.php' );
				break;
			}
		}
	}
	else
	{
		$error->notFound();
	}

	// Link footer
	require_once( APPPATH . '/themes/' . $config['default_theme'] . '/layout/footer.php' );
}
?>