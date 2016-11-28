<?php

namespace FL\FacebookPagesBundle\EventListener;

use EightPoints\Bundle\GuzzleBundle\Events\PostTransactionEvent;
use GuzzleHttp\Psr7\Stream;

/**
 * This is quite a shameful workaround for quite a shameful bug: https://github.com/facebook/php-graph-sdk/issues/700.
 */
class OpenGraphStoryIdListener
{
    public function onGuzzleBundlePostTransaction(PostTransactionEvent $event)
    {
        $body = json_decode((string) $event->getTransaction()->getBody());

        // Whatever this is, it's not our array of reviews. Maybe an error response.
        if (!is_array($body->data)) {
            return;
        }

        // These aren't our reviews after all
        if (!isset($body->data[0]->open_graph_story)) {
            return;
        }

        for ($n = 0; $n < count($body->data); ++$n) {
            $body->data[$n]->open_graph_story->data->id = $body->data[$n]->open_graph_story->id;
        }

        $streamResource = fopen('php://temp', 'r+');
        fwrite($streamResource, json_encode($body));
        rewind($streamResource);

        $event->setTransaction(
            $event->getTransaction()->withBody(new Stream($streamResource))
        );
    }
}
