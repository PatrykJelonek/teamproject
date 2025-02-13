<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 30/08/2021
 * Time: 20:45
 */

namespace App\Repositories;

use App\Models\Comment;
use App\Models\StudentJournalEntry;
use App\Repositories\Interfaces\JournalRepositoryInterface;

class JournalRepository implements JournalRepositoryInterface
{

    public function getStudentJournalEntryById(int $studentJournalEntryId)
    {
        $studentJournalEntry = StudentJournalEntry::with(['journalEntry.students'])->find($studentJournalEntryId);

        if (!empty($studentJournalEntry)) {
            return $studentJournalEntry;
        }

        return null;
    }

    public function getStudentJournalEntryComments(int $studentJournalEntryId)
    {
        $studentJournalEntryComments = StudentJournalEntry::with(['comments.user'])
            ->where(['id' => $studentJournalEntryId])->first()->comments;

        if (!empty($studentJournalEntryComments)) {
            return $studentJournalEntryComments;
        }

        return null;
    }

    public function getStudentJournalEntryComment(int $commentId)
    {
        $studentJournalEntryComment = Comment::find($commentId);

        if (!empty($studentJournalEntryComment)) {
            return $studentJournalEntryComment;
        }

        return null;
    }
}
