<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">

  

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <div class="modal-header">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary portrait_button">Print</button>
            </div>         
                <div id="printable">
                    <table cellspacing="0" border="0">
                        <colgroup width="50"></colgroup>
                        <colgroup width="100"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="350"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="150"></colgroup>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="50"></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="43" align="center" valign=middle><font face="Calibri" size=7>Intersect Corporation Ltd</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="40" align="center" valign=middle><font face="Calibri" size=5>RECEIPT</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="18" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td colspan=4></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>RECEIPT#:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_id2" size=5></font></td>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>DIST#:</font></td>
                            <td colspan=2 align="left" valign=middle><font face="Calibri" id="receipt_dist" size=5>"Boss_id" "Member Name"</font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>PRINT DATE:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_print_date" size=5>"Today"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>REMARK:</font></td>
                            <td colspan=4 align="left" valign=middle><font face="Calibri" id="receipt_remark" size=5>"Remark"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="right" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" height="32" align="center" valign=middle><font face="Calibri" size=5>#</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>Type</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle>
                                <font class="price-span" face="Calibri" size=5>Price ({{$setting['currency']}})</font>
                                <font class="coupon-span" face="Calibri" size=5>Coupons</font>
                            </td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>QTY</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle ><font face="Calibri" size=5>充值</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>1</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" id="receipt_type_label" size=5></font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_currency_amount" size=5>"Deposit in Dollars"</font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri" id="receipt_amount" size=5>"equivalent Point (Dollar / 2)"</font></td>
                        </tr>

                        <tr class="receipt-special-offer-item">
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>2</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" size=5>特別優惠積分</font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" size=5></font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"  id="receipt_special_offer_amount" size=5></font></td>
                        </tr>
                        
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-bottom: 1px solid #000000" height="24" align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>TOTAL:</font></td>
                            <td align="center" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_amount_total" size=5>"equivalent Point in total"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>BALANCE:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle><font face="Calibri" id="receipt_balance" size=5>"Member balance after top-up"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>PAYMENT:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle>
                            <font face="Calibri" size=5 class="receipt-payment-cash">現金</font>
                            <font face="Calibri" id="receipt_payment_currency_amount" size=5>HK500</font>
                        </td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>ENTRY/TERMINAL:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_staff" size=5>"staff"</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>Card Type:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_card_type" size=5>"card type</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td height="200" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td class="price-span" height="120" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri" size=5>經銷商簽名:</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="70" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=4 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2  valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle colspan=2><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=3 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="26" align="left" valign=middle><font face="Calibri" size=4>Remark: 充值分數只適用於La Concorde內使用，購買此充值分數不設退款。</font></td>
                        </tr>
                    </table>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <p style="page-break-after: always;">&nbsp;</p>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <table cellspacing="0" border="0">
                        <colgroup width="50"></colgroup>
                        <colgroup width="100"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="350"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="150"></colgroup>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="50"></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="43" align="center" valign=middle><font face="Calibri" size=7>Intersect Corporation Ltd</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="40" align="center" valign=middle><font face="Calibri" size=5>RECEIPT</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="18" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td colspan=4></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>RECEIPT#:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_id3" size=5></font></td>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>DIST#:</font></td>
                            <td colspan=2 align="left" valign=middle><font face="Calibri" id="receipt_dist2" size=5>"Boss_id" "Member Name"</font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>PRINT DATE:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_print_date2" size=5>"Today"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>REMARK:</font></td>
                            <td colspan=4 align="left" valign=middle><font face="Calibri" id="receipt_remark2" size=5>"Remark"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="right" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" height="32" align="center" valign=middle><font face="Calibri" size=5>#</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>Type</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle>
                                <font class="price-span" face="Calibri" size=5>Price ({{$setting['currency']}})</font>
                                <font class="coupon-span" face="Calibri" size=5>Coupons</font>
                            </td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>QTY</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle ><font face="Calibri" size=5>充值</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>1</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" id="receipt_type_label2" size=5></font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_currency_amount2" size=5>"Deposit in Dollars"</font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri" id="receipt_amount2" size=5>"equivalent Point (Dollar / 2)"</font></td>
                        </tr>
                        <tr class="receipt-special-offer-item">
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>2</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" size=5>特別優惠積分</font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" size=5></font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"  id="receipt_special_offer_amount2" size=5></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-bottom: 1px solid #000000" height="24" align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>TOTAL:</font></td>
                            <td align="center" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_amount_total2" size=5>"equivalent Point in total"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>BALANCE:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle><font face="Calibri" id="receipt_balance2" size=5>"Member balance after top-up"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>PAYMENT:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle>
                            <font face="Calibri" size=5 class="receipt-payment-cash">現金</font>
                            <font face="Calibri" id="receipt_payment_currency_amount2" size=5>HK500</font>
                        </td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>ENTRY/TERMINAL:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_staff2" size=5>"staff"</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>Card Type:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_card_type2" size=5>"card type</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="200" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td class="price-span" height="120" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri" size=5>經銷商簽名:</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="70" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=4 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2  valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle colspan=2><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=3 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="26" align="left" valign=middle><font face="Calibri" size=4>Remark: 充值分數只適用於La Concorde內使用，購買此充值分數不設退款。</font></td>
                        </tr>
                    </table>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <p style="page-break-after: always;">&nbsp;</p>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <table cellspacing="0" border="0">
                        <colgroup width="50"></colgroup>
                        <colgroup width="100"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="350"></colgroup>
                        <colgroup width="150"></colgroup>
                        <colgroup width="150"></colgroup>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="50"></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="43" align="center" valign=middle><font face="Calibri" size=7>Intersect Corporation Ltd</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="40" align="center" valign=middle><font face="Calibri" size=5>RECEIPT</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="18" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td colspan=4></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>RECEIPT#:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_id" size=5></font></td>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>DIST#:</font></td>
                            <td colspan=2 align="left" valign=middle><font face="Calibri" id="receipt_dist3" size=5>"Boss_id" "Member Name"</font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>PRINT DATE:</font></td>
                            <td align="left" valign=middle><font face="Calibri" id="receipt_print_date3" size=5>"Today"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="right" valign=middle><font face="Calibri" size=5>REMARK:</font></td>
                            <td colspan=4 align="left" valign=middle><font face="Calibri" id="receipt_remark3" size=5>"Remark"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="right" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" height="32" align="center" valign=middle><font face="Calibri" size=5>#</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>Type</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle>
                                <font class="price-span" face="Calibri" size=5>Price ({{$setting['currency']}})</font>
                                <font class="coupon-span" face="Calibri" size=5>Coupons</font>
                            </td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle><font face="Calibri" size=5>QTY</font></td>
                            <td style="border-top: 1px solid #000000" align="center" valign=middle ><font face="Calibri" size=5>充值</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>1</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" id="receipt_type_label3" size=5></font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_currency_amount3" size=5>"Deposit in Dollars"</font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri" id="receipt_amount3" size=5>"equivalent Point (Dollar / 2)"</font></td>
                        </tr>
                        <tr class="receipt-special-offer-item">
                            <td colspan=1></td>
                            <td height="32" align="center" valign=middle sdval="1"><font face="Calibri" size=5>2</font></td>
                            <td align="left" valign=middle><font face="DejaVu Sans" size=5>特別優惠積分</font></td>
                            <td align="left" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" size=5></font></td>
                            <td align="center" valign=middle sdval="1" sdnum="1033;"><font face="Calibri" size=5>1</font></td>
                            <td align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"  id="receipt_special_offer_amount3" size=5></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-bottom: 1px solid #000000" height="24" align="center" valign=middle><font face="Calibri" size=5><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="center" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="right" valign=middle><font face="Calibri" size=5>TOTAL:</font></td>
                            <td align="center" valign=middle sdval="500" sdnum="1033;"><font face="Calibri" id="receipt_amount_total3" size=5>"equivalent Point in total"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>BALANCE:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle><font face="Calibri" id="receipt_balance3" size=5>"Member balance after top-up"</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>PAYMENT:</font></td>
                            <td style="border-top: 1px solid #000000" colspan=3 align="left" valign=middle>
                            <font face="Calibri" size=5 class="receipt-payment-cash">現金</font>
                            <font face="Calibri" id="receipt_payment_currency_amount3" size=5>HK500</font>
                        </td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>ENTRY/TERMINAL:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_staff3" size=5>"staff"</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td style="border-top: 1px solid #000000" colspan=2 height="32" align="left" valign=middle><font face="Calibri" size=5>Card Type:</font></td>
                            <td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri" id="receipt_card_type3" size=5>"card type</font></td>
                            <td style="border-top: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>

                        <tr>
                            <td colspan=1></td>
                            <td height="200" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td class="price-span" height="120" colspan=5 align="left" valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2 valign=middle><font face="Calibri" size=5>經銷商簽名:</font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="70" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=4 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=2  valign=middle><font face="Calibri"><br></font></td>
                            <td style="border-bottom: 1px solid #000000" align="left" valign=middle colspan=2><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td height="32" align="left" valign=middle><font face="Calibri"><br></font></td>
                            <td align="left" colspan=3 valign=middle><font face="Calibri"><br></font></td>
                        </tr>
                        <tr>
                            <td colspan=1></td>
                            <td colspan=5 height="26" align="left" valign=middle><font face="Calibri" size=4>Remark: 充值分數只適用於La Concorde內使用，購買此充值分數不設退款。</font></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary portrait_button">Print</button>
            </div> -->
        </div>
    </div>
</div>