<?php

namespace App\EventListener;

use App\Repository\ParcoursRepository;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\SkillRepository;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class LoadDataListener
{
    private $twig;
    private $user;
    private $presentation;
    private $projet;
    private $parcours;
    private $skill;

    public function __construct(Environment $twig, UserRepository $user, PresentationRepository $presentation, ProjetRepository $projet, ParcoursRepository $parcours, SkillRepository $skill)
    {
        $this->twig = $twig;
        $this->user = $user->find(1);
        $this->presentation = $presentation->findAll();
        $this->projet = $projet->findBy([],['id' => 'DESC']);
        $this->parcours = $parcours->findBy([],['id' => 'DESC'], 3);
        $this->skill = $skill->findAll();
    }

    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $this->twig->addGlobal('user', $this->user);
        $this->twig->addGlobal('presentation', $this->presentation);
        $this->twig->addGlobal('projet', $this->projet);
        $this->twig->addGlobal('parcours', $this->parcours);
        $this->twig->addGlobal('skill', $this->skill);
    }
}
