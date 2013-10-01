<?php
require_once('lib/squeeks-Pusher-PHP/lib/Pusher.php');
require_once('../../src/php/Activity.php');
require_once('config.php');

$activity_type = $_GET['activity_type'];
$activity_data = null;
$email = null;

if( isset($_GET['activity_data']) ){
  $activity_data = $_GET['activity_data'];
}
if( isset($_GET['email']) ){
  $email = $_GET['email'];
}

$action_text = getActionText($activity_type, $activity_data);

$activity = new Activity($activity_type, $action_text, $email);

$pusher = new Pusher('23e909f6c1d71ec2df0f','0af4a2077dfbbe513eec', '55463');

$pusher->trigger('site-activity', $activity_type,$activity->getMessage());

//array('message' => 'Hello World')
/****************************************************************************************/

function getActionText($activity_type, $activity_data) {
  $action_text = 'just did something unrecognisable.';
  switch($activity_type) {
    case 'page-load':
      $action_text = 'just navigated to the Activity Streams example page.';
      break;
    case 'test-event':
      $action_text = 'just clicked the <em>Send Test</em> button.';
      break;
    case 'scroll':
      $action_text = 'just scrolled to the '. $activity_data['position'] . ' of the page';
      break;
    case 'like':
      $action_text = 'just liked: "'. $activity_data['text'] . '"';
      break;
  }
  return $action_text;
}
?>