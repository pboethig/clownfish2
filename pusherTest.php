<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '4da40e8ec548e549b271',
    '36e3a36775c23993e468',
    '798326',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('subscription_succeeded', 'subscription_succeeded', $data);
?>

