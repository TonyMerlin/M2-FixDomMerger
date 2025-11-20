#M2-FixDomMerger

Hooks into Magento\Framework\View\Element\UiComponent\Config\DomMerger::merge(). Skips the merge if the XML is empty (or whitespace). Adds logging to see who is calling it with empty XML.
