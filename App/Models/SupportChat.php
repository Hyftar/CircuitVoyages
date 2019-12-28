<?php

namespace App\Models;

use Core\Model;
use PDO;

class SupportChat extends Model
{
    public static function setInactive($room_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'UPDATE chat_rooms
             SET is_active = 0
             WHERE id = :room_id'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getAllMessagesFromRoom($room_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                 chat_lines.id,
                 date_time,
                 room_id,
                 content,
                 members_chat_lines.member_id,
                 employees_chat_lines.employee_id
             FROM chat_lines
             JOIN chat_rooms ON room_id = chat_rooms.id
             LEFT JOIN employees_chat_lines ON employees_chat_lines.chat_line_id = chat_lines.id
             LEFT JOIN members_chat_lines ON members_chat_lines.chat_line_id = chat_lines.id
             WHERE room_id = :room_id
             ORDER BY date_time ASC'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function memberCanSendIn($member_id, $room_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT id
             FROM chat_rooms
             WHERE
               id = :room_id AND
               member_id = :member_id AND
               is_active = 1
             LIMIT 1;'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch() != false;
    }

    public static function getMessageAt($room_id, $message_index)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                 chat_lines.id AS id,
                 date_time,
                 room_id,
                 content,
                 members_chat_lines.member_id AS member_id,
                 employees_chat_lines.employee_id AS employee_id
             FROM chat_lines
             JOIN chat_rooms ON room_id = chat_rooms.id
             LEFT JOIN employees_chat_lines ON employees_chat_lines.chat_line_id = chat_lines.id
             LEFT JOIN members_chat_lines ON members_chat_lines.chat_line_id = chat_lines.id
             WHERE room_id = :room_id
             ORDER BY date_time ASC
             LIMIT 1
             OFFSET :message_index'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindValue(':message_index', $message_index, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getMessageCount($room_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT COUNT(*) as count FROM chat_lines WHERE room_id = :room_id'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllRoomsFromMember($member_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                cr.id AS id,
                cr.is_active,
                cr.opened_at,
                e.id AS employee_id,
                e.first_name AS employee_first_name,
                e.last_name AS employee_last_name
             FROM chat_rooms cr
             LEFT JOIN employees e on cr.employee_id = e.id
             WHERE member_id = :member_id
             ORDER BY
                 is_active DESC,
                 opened_at DESC'
        );
        $stmt->bindValue(':member_id', $member_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllRooms()
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT * FROM chat_rooms
             ORDER BY
                 is_active DESC,
                 employee_id ASC,
                 opened_at ASC'
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($member_id)
    {
        $errors = [];
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT id FROM chat_rooms
             WHERE member_id = :member_id AND is_active = 1
             LIMIT 1'
        );

        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch()) {
            $errors[] = 'Vous avez déjà une conversation active, veuillez la quitter avant d\'en créer une nouvelle.';
        }

        if (empty($errors)) {
            $stmt = $db->prepare(
                'INSERT INTO chat_rooms (member_id) VALUES (:member_id)'
            );

            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        return [$errors, $db->lastInsertId()];
    }

    public static function memberSendMessage($member_id, $room_id, $content)
    {
        $db = static::getDB();
        $db->beginTransaction();
        $stmt = $db->prepare(
            'INSERT INTO chat_lines (content, room_id)
             VALUES (:content, :room_id)'
        );

        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();

        $chat_line_id = $db->lastInsertId();

        $stmt = $db->prepare(
            'INSERT INTO members_chat_lines (member_id, chat_line_id)
             VALUES (:member_id, :chat_line_id)'
        );


        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->bindValue(':chat_line_id', $chat_line_id, PDO::PARAM_INT);
        $stmt->execute();

        $db->commit();
    }

    public static function serverSendMessage($room_id, $content)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO chat_lines (room_id, content)
             VALUES (:room_id, :content)'
        );

        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);

        $stmt->execute();
    }
}
