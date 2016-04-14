<?php

namespace CPanelAPI;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends SymfonyCommand
{
    /**
     * @param string $module
     * @param string $function
     * @param array|null $params
     * @return string
     */
    private function getUrl(
        $module,
        $function,
        array $params = []
    ) {
        return 'https://' . getenv('DOMAIN') . ':' . getenv('CPANEL_PORT') . '/json-api/cpanel?' .
            http_build_query(array_merge([
                'user' => getenv('SSH_USER'),
                'cpanel_jsonapi_apiversion' => 2,
                'cpanel_jsonapi_module' => $module,
                'cpanel_jsonapi_func' => $function
            ], $params));
    }

    /**
     * @param OutputInterface $output
     * @param string $module
     * @param string $function
     * @param array|null $params
     * @return string|array
     */
    protected function call(
        OutputInterface $output,
        $module,
        $function,
        array $params = []
    ) {
        try {
            $client = new \GuzzleHttp\Client;
            $response = $client->request('GET', $this->getUrl($module, $function, $params), [
                'auth' => [getenv('SSH_USER'), getenv('SSH_PASSWORD')]
            ]);
            $body = json_decode($response->getBody());

            if (isset($body->cpanelresult->error) && $body->cpanelresult->error != '1') {
                throw new \Exception($body->cpanelresult->error);
            }

            $output->writeln('<fg=green>Success!</>');
            $data = $body->cpanelresult->data;

            if (isset($data[0]->status) && $data[0]->status === 0) {
                throw new \Exception($data[0]->statusmsg ?: $data[0]->reason);
            }

            return $data;

        } catch (\Exception $e) {
            $output->writeln('<error>Failed: ' . $e->getMessage() . '</error>');
        }
    }
}
