<?php
namespace App\Http\Controllers;

use App\Reply;
use Exception;
use App\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread)
    {
        if(Gate::denies('create', new Reply)){
            return response('You are posting too frequently. Please take a break. :)', 422);
        }

        try{
            //TODO: For Laravel 5.5
            // request()->validate(['body' => 'required|spamfree']);
            $this->validate(request(), [
                'body' => 'required|spamfree'
            ]);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            return response('Sorry your reply could not be saved at this time.', 422);
        }

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try{
            $this->validate(request(), [
                'body' => 'required|spamfree'
            ]);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry your reply could not be saved at this time.', 422);
        }
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()){
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }
}
