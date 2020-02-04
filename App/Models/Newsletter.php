<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use PDO;

class Newsletter extends \Core\Model
{
    public static function getNewsletters(){
        $db = static::getDB();
        $stmt = $db->prepare('
            SELECT t.name, t.id, r.newsletter_message_date, r.subject
            FROM newsletters t
            LEFT JOIN
            (
                  SELECT newsletter_id, subject, newsletter_message_date, MAX(newsletter_message_date) as MaxTime
                  FROM newsletters_messages
                  GROUP BY id
                  ORDER BY id DESC
            ) r
            ON t.id = r.newsletter_id
            GROUP by t.id, t.name, r.newsletter_message_date, r.subject
            ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function createNewsletter($name){
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO newsletters
            (
                name
            )
            VALUES
            (
                :name
            )
            ');
        $stmt->bindvalue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function getNewsletterMessages($newsletter_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT newsletters_messages.id,
            newsletters_messages.newsletter_message_date,
            newsletters_messages.subject,
            newsletters_messages.content
            FROM newsletters_messages
            WHERE newsletters_messages.newsletter_id = :id
            ORDER BY newsletter_message_date DESC
            ');
        $stmt->bindvalue(':id', $newsletter_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getNewsletterMessage($newsletter_message_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT newsletters_messages.id,
            newsletters_messages.newsletter_message_date,
            newsletters_messages.subject,
            newsletters_messages.content
            FROM newsletters_messages
            WHERE newsletters_messages.id = :id
            ORDER BY newsletter_message_date DESC
            ');
        $stmt->bindvalue(':id', $newsletter_message_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function sendNewsletterMessage($subject, $content, $newsletter_id){
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO newsletters_messages
            (
                newsletter_id,
                content,
                newsletter_message_date,
                subject
            )
            VALUES
            (
                :id,
                :content,
                NOW(),
                :subject
            )
            ');
        $stmt->bindvalue(':id', $newsletter_id, PDO::PARAM_INT);
        $stmt->bindvalue(':content', $content, PDO::PARAM_STR);
        $stmt->bindvalue(':subject', $subject, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function deleteNewsletter($newsletterId){
        $db = static::getDB();
        $db->beginTransaction();
        $stmt = $db->prepare('DELETE FROM members_newsletters
            WHERE newsletter_id = :id');

        $stmt->bindvalue(':id', $newsletterId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $stmt = $db->prepare('DELETE FROM newsletters_messages
            WHERE newsletter_id = :id');
        $stmt->bindvalue(':id', $newsletterId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }
        $stmt = $db->prepare('DELETE FROM newsletters
            WHERE id = :id');
        $stmt->bindvalue(':id', $newsletterId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }
        $db->commit();
    }

    public static function getNewsletterMembers($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT members.first_name,
            members.last_name,
            members.email
            FROM members
            INNER JOIN members_newsletters
            ON members_newsletters.member_id = members.id
            WHERE members_newsletters.newsletter_id = :id');
        $stmt->bindvalue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getNewsletter($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM newsletters WHERE id = :id');
        $stmt->bindvalue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateNewsletter($id, $name){
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE newsletters SET name = :name WHERE id = :id');
        $stmt->bindvalue(':id',$id, PDO::PARAM_INT);
        $stmt->bindvalue(':name',$name, PDO::PARAM_STR);
        $stmt->execute();
    }

}
