# cobby-magento2-custom-product-type

this is an extension to manipulate product types during product import and export 

#### product update json example:

```json
{"jsonData":"[{\"sku\":\"virtual\",\"product_type\":\"simple\",\"attribute_set\":\"Default\",\"entity_id\":2049,\"websites\":[],\"attributes\":[{\"store_id\":\"0\",\"name\":\"virtual12\"}]}]","transactionId":"id"}
```

#### product import json example:
```json
{"jsonData":"[{\"sku\":\"foo_myTest\",\"product_type\":\"simple\",\"attribute_set\":\"Top\",\"websites\":[\"base\",\"test\"],\"attributes\":[{\"store_id\":\"0\",\"news_to_date\":\"\",\"short_description\":\"\",\"news_from_date\":\"\",\"ts_dimensions_height\":\"\",\"ts_dimensions_width\":\"\",\"ts_dimensions_length\":\"\",\"status\":\"1\",\"options_container\":\"container2\",\"custom_layout\":\"\",\"meta_description\":\"\",\"custom_design\":\"\",\"meta_keyword\":\"\",\"name\":\"myTest custom product type\",\"msrp_display_actual_price_type\":\"0\",\"custom_design_to\":\"\",\"meta_title\":\"\",\"custom_design_from\":\"\",\"url_key\":\"\",\"tax_class_id\":\"2\",\"custom_layout_update\":\"\",\"visibility\":\"4\",\"description\":\"\",\"special_to_date\":\"\",\"page_layout\":\"\",\"special_from_date\":\"\",\"country_of_manufacture\":\"\"},{\"store_id\":\"2\",\"collar\":\"\",\"sleeve\":\"\",\"activity\":\"\",\"sale\":\"\",\"new\":\"\",\"erin_recommends\":\"\",\"performance_fabric\":\"\",\"eco_collection\":\"\",\"color\":\"49\",\"climate\":\"\",\"pattern\":\"\",\"size\":\"91\",\"special_price\":\"\",\"material\":\"\",\"style_general\":\"\",\"media_gallery\":\"\",\"gallery\":\"\",\"weight\":\"\",\"cost\":\"\",\"gift_message_available\":\"\",\"quantity_and_stock_status\":\"1\",\"msrp\":\"\",\"price\":\"1\"}]}]","transactionId":"id"}
```

[Link to Postman collection](https://github.com/mash2/cobby-postman/blob/master/Magento2/customProductType%20m2.postman_collection.json)