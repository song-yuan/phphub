<?php namespace Phphub\Topic;

use Phphub\Forms\TopicCreationForm;
use Phphub\Core\CreatorListener;
use Topic, Auth;

class TopicCreator
{
    protected $topicModel;
    protected $form;

    public function __construct(Topic $topicModel, TopicCreationForm $form)
    {
        $this->userModel  = $topicModel;
        $this->form = $form;
    }

    public function create(CreatorListener $observer, $data)
    {
        $data['user_id'] = Auth::user()->id;

        // Validation
        $this->form->validate($data);

        $topic = Topic::create($data);
        if ( ! $topic) 
        {
            return $observer->creatorFailed($topic->getErrors());
        }

        return $observer->creatorSucceed($topic);
    }
}