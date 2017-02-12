<?php

if (isset($_GET['order']))
{?>
    <?php

    if (isset($_POST['order_name']) && isset($_POST['order_phone']) && isset($_POST['order_amount']) && isset($_POST['order_date']) && isset($_POST['order_address']))
    {
        $order_name = $_POST['order_name'];
        $order_phone = $_POST['order_phone'];
        if (trim($order_phone) == "+7" || trim($order_phone) == "")
            $order_phone = "не указан";
        $order_amount = $_POST['order_amount'];
        $order_date = $_POST['order_date'];
        $order_address = $_POST['order_address'];
        $order_message = $_POST['order_message'];

        if (trim($order_name) == "" || trim($order_amount) == "" || trim($order_date) == "" || trim($order_address) == "")
        {?>
            <div class="modal-wrap">
                <br /><br /><br />

                <h2>Поля заполнены неверно!</h2>

                <br /><br /><br />
            </div>
            
            <?
            return false;
        }

        /* ========== */
        $content = "Заполнена форма заказа доставки молока на сайте allmilk.ga.\n\nИмя: {$order_name}\nТелефон: {$order_phone}\nКоличество литров: {$order_amount}\nДата доставки: {$order_date}\nАдрес доставки: {$order_address}\nКомментарий: {$order_message}\n\n\nСообщение сформировано автоматически.\n";
        $from_user = '=?UTF-8?B?'.base64_encode('allmilk.ga').'?=';
        $subject = '=?UTF-8?B?'.base64_encode('Форма заказа доставки молока allmilk.ga').'?=';

        $headers = 'From: '.$from_user.' <email_here>' . "\r\n" .
        'Reply-To: email_here' . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/plain; charset=utf-8' . "\r\n" .
        'Return-Path: email_here.' . "\r\n";

        $params = "-femail_here";

        mail("email_here", $subject, $content, $headers, $params);
        /* ========== */

        $message_array = array();
        $message_array['current_date'] = date('d.m.Y H:i:s') . ' UTC';
        $message_array['order_name'] = $order_name;
        $message_array['order_phone'] = $order_phone;
        $message_array['order_amount'] = $order_amount;
        $message_array['order_date'] = $order_date;
        $message_array['order_address'] = $order_address;
        $message_array['order_message'] = $order_message;

        $messages_json = array();
        if (file_exists('./orders.json'))
        {
            $tmp = file_get_contents('./orders.json');
            $messages_json = (array)json_decode($tmp);
        }
        $messages_json[] = $message_array;

        file_put_contents('./orders.json', json_encode($messages_json));

        /* ========== */

        ?>

        <div class="modal-wrap">
            <br /><br /><br />

            <h2>Заказ на доставку успешно оформлен!</h2><br />
            <h3>Ожидайте звонка</h3>
            <?php
            $sum = 0;
            $order_amount = floatval($order_amount);
            if ($order_amount < 3)
                $sum = $order_amount * 120;
            else
                $sum = $order_amount * 100;
            ?>
            <h3>Сумма заказа: <?=$sum?>₽</h3>

            <br /><br /><br />
        </div>

        <?
        return true;
    }

    ?>
    <div class="modal-wrap">
        
        <h2>Сделать заказ на доставку</h2>

        <form class="order_form" name="order_form" id="order_form" action="/ajax.php?order" method="POST" onsubmit="return ajaxFormTry($(this));">
            <label>*</label><input name="order_name" type="text" placeholder="Ваше имя" title="Ваше имя" required="">
            <br /><label>*</label><input name="order_phone" type="text" placeholder="Номер телефона" class="order_phone" title="Номер телефона" maxlength="18" autocomplete="off" required="">
            <br class="desktop_hidden" /><label class="desktop_hidden">*</label><input name="order_amount" type="number" min="0" step="any" placeholder="Количество литров" class="order_amount" title="Количество литров" maxlength="18" autocomplete="off" required="">
            <br /><label>*</label><input id="datetimepicker" name="order_date" type="text" placeholder="Дата/Время" class="order_date" title="Дата/Время" required="">
            <br /><label>*</label><input type="text" name="order_address" placeholder="Адрес доставки в г.Ростов-на-Дону" title="Адрес доставки в г.Ростов-на-Дону" required="" value="г.Ростов-на-Дону, ул. ">
            <br /><label>&nbsp;</label><textarea name="order_message" placeholder="Комментарий" title="Комментарий"></textarea>
            <br /><input type="submit" name="submit_order" value="Заказать">
        </form>

        <div class="desc order_info_text">
        <p>* Коровы дают молоко в 6 утра и в 8 вечера ежедневно</p>
        <p>** Оплата при получении</p>
        </div>

    </div>

    <script>
        $(document).ready(function(){
            $('.order_phone').mask('+0 (000) 000-00-00');
            $('.order_phone').on('click', function() {
                if ( $('.order_phone').val() == "" )
                    $('.order_phone').val('+7 ');
            });

            $('#datetimepicker').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                step: 30,
                format:'d.m.Y H:i',
                minDate:'-1970/01/01' // yesterday is minimum date
            });
        });
    </script>

<? } ?>

<script type="text/javascript">
  (function (d, w, c) {
  (w[c] = w[c] || []).push(function() {
  try {
  w.yaCounter38434015 = new Ya.Metrika({
  id:38434015,
  clickmap:true,
  trackLinks:true,
  accurateTrackBounce:true,
  webvisor:true
  });
  } catch(e) { }
  });
  var n = d.getElementsByTagName("script")[0],
  s = d.createElement("script"),
  f = function () { n.parentNode.insertBefore(s, n); };
  s.type = "text/javascript";
  s.async = true;
  s.src = "https://mc.yandex.ru/metrika/watch.js";
  if (w.opera == "[object Opera]") {
  d.addEventListener("DOMContentLoaded", f, false);
  } else { f(); }
  })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
  <div><img src="https://mc.yandex.ru/watch/38434015" style="position:absolute; left:-9999px;" alt=""></div>
</noscript>