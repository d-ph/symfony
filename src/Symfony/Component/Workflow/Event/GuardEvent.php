<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Workflow\Event;

use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\TransitionBlocker;
use Symfony\Component\Workflow\TransitionBlockerList;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class GuardEvent extends Event
{
    private $blocked = false;
    private $transitionBlockerList;

    /**
     * {@inheritdoc}
     */
    public function __construct($subject, Marking $marking, Transition $transition, $workflowName = 'unnamed')
    {
        parent::__construct($subject, $marking, $transition, $workflowName);

        $this->transitionBlockerList = new TransitionBlockerList();
    }

    public function isBlocked()
    {
        return $this->blocked;
    }

    public function setBlocked($blocked)
    {
        $this->blocked = (bool) $blocked;
    }

    /**
     * Get transition blocker list.
     *
     * @return TransitionBlockerList
     */
    public function getTransitionBlockerList()
    {
        return $this->transitionBlockerList;
    }

    public function addTransitionBlocker(TransitionBlocker $transitionBlocker)
    {
        $this->transitionBlockerList->add($transitionBlocker);

        $this->setBlocked(true);
    }
}
