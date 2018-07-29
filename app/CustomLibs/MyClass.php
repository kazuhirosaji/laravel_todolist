<?
namespace App\CustomLibs;
// require __DIR__.'/../../vendor/autoload.php';
// require __DIR__.'/../../vendor/google/apiclient/src/Google/Client.php';
// putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '../../credentials.json');

class MyClass{
    const KEY_FILE_LOCATION = __DIR__ . '/../../config/secret/credentials.json';
    const TOKEN_FILE_LOCATION = __DIR__ . '/../../config/secret/token.json';

    public function sayHello(){
        return "Hello!";
    }

    public function calendarEvent() {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        return redirect($client);
    }

    public function getClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(\Google_Service_Calendar::CALENDAR_READONLY);

        logger(self::KEY_FILE_LOCATION);
        $client->setAuthConfig(self::KEY_FILE_LOCATION);
        $client->setAccessType('offline');
        // $client->setIncludeGrantedScopes(true);
        $client->setRedirectUri('http://localhost:8080/callback');

        // Load previously authorized credentials from a file.
        $credentialsPath = self::TOKEN_FILE_LOCATION;
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            logger($authUrl);
            return $authUrl;
            // $authCode = trim(fgets(STDIN));
            // $authCode = ${GOOGLE_CALENDAR_API_AUTH_CODE};

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            logger($accessToken);

            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function calendarCallback($code) {
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(\Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig(self::KEY_FILE_LOCATION);
        $client->setRedirectUri('http://localhost:8080/callback');

        $accessToken = $client->authenticate($code);
        logger($accessToken);
        $client->setAccessToken($accessToken);
        $_SESSION['access_token'] = $accessToken;

        // $accessToken = $client->getAccessToken();
        $service = new \Google_Service_Calendar($client);

        // Print the next 10 events on the user's calendar.
        $calendarId = 'primary';
        $optParams = array(
          'maxResults' => 10,
          'orderBy' => 'startTime',
          'singleEvents' => true,
          'timeMin' => date('c'),
        );
        $results = $service->events->listEvents($calendarId, $optParams);

        if (empty($results->getItems())) {
            print "No upcoming events found.\n";
        } else {
            print "Upcoming events:\n";
            foreach ($results->getItems() as $event) {
                $start = $event->start->dateTime;
                if (empty($start)) {
                    $start = $event->start->date;
                }
                printf("%s (%s)\n", $event->getSummary(), $start);
            }
        }



    }

}