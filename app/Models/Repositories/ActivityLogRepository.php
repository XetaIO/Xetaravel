<?php
namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\ActivityLog;

class ActivityLogRepository
{
    /**
     * Update the activity log if it exist or create and save it.
     *
     * @param array $data The data used to update/create the log.
     * @param int $id The user id related to the activity log.
     *
     * @return \Xetaravel\Models\ActivityLog
     */
    public static function update(array $data, int $id): ActivityLog
    {
        return ActivityLog::updateOrCreate(
            [
                'user_id' => $id
            ],
            [
                'user_id' => $id,
                'method' => $data['method'],
                'ip' => $data['ip'],
                'url' => $data['url'],
                'user_agent' => $data['user_agent'],
                'last_activity' => $data['last_activity']
            ]
        );
    }
}
