<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Teams\InjectTeamsService;
use App\Http\Services\Teams\EditTeamsService;
use App\Http\Services\Teams\DeleteTeamsService;
use App\Http\Services\Teams\AddMemberService;
use App\Http\Services\Teams\RemoveMemberService;
use App\Http\Services\Teams\TeamDetailsService;
use App\Http\Services\Teams\GetMembersService;
use App\Http\Services\Teams\InviteByEmailService;

class teamsController extends Controller
{
    /**
     * Insert Team
     *
     * @return  json  team id
     */
    public function inject(
        Request $request,
        InjectTeamsService $teams
    )
    {
        $data = $request->all();
        return $teams->handle($data);
    }

    /**
     * Edit Team Details
     *
     * @return  json  updated team details
     */
    public function edit(
        Request $request,
        EditTeamsService $teams,
        $id
    )
    {
        $data = $request->all();
        $data['teams_id'] = $id;
        return $teams->handle($data);
    }

    /**
     * Delete Team
     *
     * @return  json  message
     */
    public function delete(
        DeleteTeamsService $teams,
        $id
    )
    {
        return $teams->handle($id);
    }

    /**
     * Add Member on Team
     *
     * @return  json  member info
     */
    public function addMember(
        Request $request,
        AddMemberService $member
    )
    {
        $data = $request->all();
        return $member->handle($data);
    }

    /**
     * Remove Member on Team
     *
     * @return  json  message
     */
    public function removeMember(
        RemoveMemberService $member,
        $id
    )
    {
        return $member->handle($id);
    }

    /**
     * Get Team Details
     *
     * @return  json  team details
     */
    public function getTeam(
        TeamDetailsService $team,
        $id
    )
    {
        return $team->handle($id);
    }

    public function getMembers(
        GetMembersService $teamMembers,
        $team_id,
        Request $request
    )
    {
        $data = $request->all();
        $data['team_id'] = $team_id;
        return $teamMembers->handle($data);
    }

    public function inviteByEmail(
        Request $request,
        InviteByEmailService $byemail
    )
    {
        $data = $request->all();
        return $byemail->handle($data);
    }

}
