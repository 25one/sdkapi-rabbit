<?php

namespace SdkBonusApi;

require_once 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class WorkerSender 
{
    /* ... ЗДЕСЬ КАКОЙ-ТО КОД ... */
    /**
    * Отправляет задачу на генерацию накладной обработчикам
    *
    * @param string $parameterssend (...whnen array)
   */
      public function execute($parameterssend) 
      {
          $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
          $channel = $connection->channel();
          $channel->queue_declare(
                'invoice_queue',    #queue name - Имя очереди может содержать до 255 байт UTF-8 символов
                false,              #passive - может использоваться для проверки того, инициирован ли обмен, без того, чтобы изменять состояние сервера
                true,               #durable - убедимся, что RabbitMQ никогда не потеряет очередь при падении - очередь переживёт перезагрузку брокера
                false,              #exclusive - используется только одним соединением, и очередь будет удалена при закрытии соединения
                false               #autodelete - очередь удаляется, когда отписывается последний подписчик
                );
    
          $msg = new AMQPMessage(
                $parameterssend,     //!!!$parameterssend - MESSAGE...
                array('delivery_mode' => 2) #создаёт сообщение постоянным, чтобы оно не потерялось при падении или закрытии сервера
                );
     
          $channel->basic_publish(
                $msg,                       #сообщение
                '',                         #обмен
                'invoice_queue'             #ключ маршрутизации (очередь)
                );
     
          $channel->close();
          $connection->close();
      } 
}
