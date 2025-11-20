<?php
declare(strict_types=1);

namespace Vendor\FixDomMerger\Plugin;

use Magento\Framework\View\Element\UiComponent\Config\DomMerger;
use Psr\Log\LoggerInterface;

class DomMergerPlugin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Skip merging when XML string is empty to avoid PHP 8.1 ValueError.
     *
     * @param DomMerger $subject
     * @param callable $proceed
     * @param string $xml
     * @return void
     */
    public function aroundMerge(DomMerger $subject, callable $proceed, $xml)
    {
        $xml = (string)$xml;

        // PHP 8.1+: DOMDocument::loadXML('') throws ValueError.
        if (trim($xml) === '') {
            // Optional: comment this out if you dont need to track the caller
             $this->logger->warning(
                'DomMerger::merge() called with empty XML',
                ['backtrace' => (new \Exception())->getTraceAsString()]
            );
            return;
        }

        return $proceed($xml);
    }
}
