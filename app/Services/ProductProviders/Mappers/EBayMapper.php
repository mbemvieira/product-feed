<?php

namespace App\Services\ProductProviders\Mappers;

use DateInterval;
use DateTime;

class EbayMapper extends AbstractMapper
{
    public function __construct($content)
    {
        if (
            !isset($content->findItemsByKeywordsResponse[0]->ack[0]) ||
            $content->findItemsByKeywordsResponse[0]->ack[0] != 'Success' ||
            !isset($content->findItemsByKeywordsResponse[0]->paginationOutput[0]) ||
            !isset($content->findItemsByKeywordsResponse[0]->searchResult[0]->item)
        ) {
            $this->isValidContent = false;
            return;
        }

        $paginationOutput = $content->findItemsByKeywordsResponse[0]->paginationOutput[0];
        $this->pagination['page'] = $paginationOutput->pageNumber[0];
        $this->pagination['itemsPerPage'] = $paginationOutput->entriesPerPage[0];
        $this->pagination['totalPages'] = $paginationOutput->totalPages[0];
        $this->pagination['totalItems'] = $paginationOutput->totalEntries[0];

        $items = $content->findItemsByKeywordsResponse[0]->searchResult[0]->item;

        foreach ($items as $item) {
            $product = [
                'provider' => 'eBay',
                'item_id' => $item->itemId[0],
                'click_out_link' => $item->viewItemURL[0] ?? null,
                'main_photo_url' => $item->galleryURL[0] ?? null,
                'price' => $item->sellingStatus[0]->currentPrice[0]->__value__ ?? 0,
                'price_currency' => $item->sellingStatus[0]->currentPrice[0]->{'@currencyId'} ?? 'USD',
                'shipping_price' => $item->sellingStatus[0]->shippingServiceCost[0]->__value__ ?? null,
                'title' => $item->title[0] ?? 'No Title',
                'description' => null,
                'valid_until' => $item->listingInfo[0]->endTime[0] ?? null,
                'brand' => null,
                'expiry_datetime' => (new DateTime('now'))
                    ->add(new DateInterval('P1D'))
                    ->format('Y-m-d H:i:s'),
            ];

            $this->products[] = $product;
        }
    }
}
