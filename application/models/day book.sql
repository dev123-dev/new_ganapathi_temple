SELECT '' as sevaName, DEITY_RECEIPT.RECEIPT_ID as rId, RECEIPT_NO as rNo,RECEIPT_DATE as rDate,RECEIPT_CATEGORY_ID as rCatId, RECEIPT_DEITY_NAME as rName, RECEIPT_ISSUED_BY as rNameBy,RECEIPT_PAYMENT_METHOD as rPayMethod,RECEIPT_PRICE as amt,POSTAGE_PRICE as amtPostage,RECEIPT_NAME as user, PAYMENT_STATUS as status, "deity" as rType, RECEIPT_ACTIVE as rActive FROM DEITY_RECEIPT where (RECEIPT_CATEGORY_ID = 2 or RECEIPT_CATEGORY_ID = 3 or RECEIPT_CATEGORY_ID = 4 or RECEIPT_CATEGORY_ID = 6) AND RECEIPT_DATE = '04-03-2019' UNION ALL SELECT SO_SEVA_NAME as sevaName, DEITY_RECEIPT.RECEIPT_ID as rId, RECEIPT_NO as rNo,RECEIPT_DATE as rDate,RECEIPT_CATEGORY_ID as rCatId, SO_DEITY_NAME as rName, RECEIPT_ISSUED_BY as rNameBy,RECEIPT_PAYMENT_METHOD as rPayMethod,SO_PRICE as amt,POSTAGE_PRICE as amtPostage,RECEIPT_NAME as user, PAYMENT_STATUS as status, "deity" as rType, RECEIPT_ACTIVE as rActive FROM DEITY_RECEIPT join DEITY_SEVA_OFFERED on DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID WHERE RECEIPT_DATE = '04-03-2019' UNION ALL SELECT '' as sevaName, DEITY_RECEIPT.RECEIPT_ID as rId, RECEIPT_NO as rNo,RECEIPT_DATE as rDate,RECEIPT_CATEGORY_ID as rCatId, RECEIPT_DEITY_NAME as rName, RECEIPT_ISSUED_BY as rNameBy,RECEIPT_PAYMENT_METHOD as rPayMethod,'' as amt,POSTAGE_PRICE as amtPostage,RECEIPT_NAME as user, PAYMENT_STATUS as status, "deity" as rType, RECEIPT_ACTIVE as rActive FROM DEITY_RECEIPT join DEITY_INKIND_OFFERED on DEITY_INKIND_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID WHERE RECEIPT_DATE = '04-03-2019' group by DEITY_RECEIPT.RECEIPT_ID UNION ALL SELECT '' as sevaName, EVENT_RECEIPT.ET_RECEIPT_ID as rId, ET_RECEIPT_NO as rNo,ET_RECEIPT_DATE as rDate,ET_RECEIPT_CATEGORY_ID as rCatId, RECEIPT_ET_NAME as rName, ET_RECEIPT_ISSUED_BY as rNameBy,ET_RECEIPT_PAYMENT_METHOD as rPayMethod,ET_RECEIPT_PRICE as amt,POSTAGE_PRICE as amtPostage,ET_RECEIPT_NAME as user, PAYMENT_STATUS as status, "event" as rType, ET_RECEIPT_ACTIVE as rActive FROM EVENT_RECEIPT where (ET_RECEIPT_CATEGORY_ID = 2 or ET_RECEIPT_CATEGORY_ID = 3) AND ET_RECEIPT_DATE = '04-03-2019' UNION ALL SELECT ET_SO_SEVA_NAME as sevaName, EVENT_RECEIPT.ET_RECEIPT_ID as rId, ET_RECEIPT_NO as rNo,ET_RECEIPT_DATE as rDate,ET_RECEIPT_CATEGORY_ID as rCatId, RECEIPT_ET_NAME as rName, ET_RECEIPT_ISSUED_BY as rNameBy,ET_RECEIPT_PAYMENT_METHOD as rPayMethod,ET_SO_PRICE as amt,POSTAGE_PRICE as amtPostage,ET_RECEIPT_NAME as user, PAYMENT_STATUS as status, "event" as rType, ET_RECEIPT_ACTIVE as rActive FROM EVENT_RECEIPT join EVENT_SEVA_OFFERED on EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID WHERE ET_RECEIPT_DATE = '04-03-2019' UNION ALL SELECT '' as sevaName, EVENT_RECEIPT.ET_RECEIPT_ID as rId, ET_RECEIPT_NO as rNo,ET_RECEIPT_DATE as rDate,ET_RECEIPT_CATEGORY_ID as rCatId, RECEIPT_ET_NAME as rName, ET_RECEIPT_ISSUED_BY as rNameBy,ET_RECEIPT_PAYMENT_METHOD as rPayMethod,'' as amt,POSTAGE_PRICE as amtPostage,ET_RECEIPT_NAME as user, PAYMENT_STATUS as status, "event" as rType, ET_RECEIPT_ACTIVE as rActive FROM EVENT_RECEIPT join EVENT_INKIND_OFFERED on EVENT_INKIND_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID WHERE ET_RECEIPT_DATE = '04-03-2019' group by EVENT_RECEIPT.ET_RECEIPT_ID order by STR_TO_DATE(rDate,'%d-%m-%Y') DESC