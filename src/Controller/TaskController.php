<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\CreateType;
use App\Form\EditType;
use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{
    public function index()
    {

        
        $em = $this->getDoctrine()->getManager();

        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    public function detail(Task $task){
        if(!$task){
            return $this->redirectToRoute('index');
        }
        
        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }

    public function create(Request $request, UserInterface $user){

        $task = new Task();
        $form = $this->createForm(CreateType::class, $task);

        $form->handleRequest($request); 
        
        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \Datetime('now'));
            $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id' => $task->getId()])
            );
        }


        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function myTasks(UserInterface $user){
        $tasks = $user->getTasks();
        
        return $this->render('task/mytasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function edit(Request $request, Task $task, UserInterface $user){

        if(!$task){
            return $this->redirectToRoute('index');
        }else{
            if(!$user || $user->getId() != $task->getUser()->getId()){
                return $this->redirectToRoute('index');
            }else{
                $form = $this->createForm(EditType::class, $task);
    
                $form->handleRequest($request); 
            
                if($form->isSubmitted() && $form->isValid()){
                    $task->setCreatedAt(new \Datetime('now'));
                    $task->setUser($user);
    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($task);
                    $em->flush();
    
                    return $this->redirect(
                        $this->generateUrl('task_detail', ['id' => $task->getId()])
                    );
                }
            }
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function delete(Task $task,  UserInterface $user){
        
        if(!$task){
            return $this->redirectToRoute('index');
        }else{
            if(!$user || $user->getId() != $task->getUser()->getId()){
                return $this->redirectToRoute('index');
            }else{
                $em = $this->getDoctrine()->getManager();
                $em->remove($task);
                $em->flush();

                return $this->redirectToRoute('index');
            }
        }
    }
}