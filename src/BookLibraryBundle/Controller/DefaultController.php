<?php

namespace BookLibraryBundle\Controller;

use BookLibraryBundle\Entity\Book;
use BookLibraryBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="book_list")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository("BookLibraryBundle:Book");
        if($data = $this->get('cache')->fetch('books')){
            $bookList = unserialize($data);
        }
        else{
            $bookList = $repository->findBy(array(),array("id" => "ASC"));
            $this->get('cache')->save('books', serialize($bookList), $this->getParameter('cache_lifetime'));
        }

        return $this->render('base.html.twig', array(
            "books" => $bookList,
            "upload_path" => array(
                "upload" => $this->getParameter('upload_directory_relative'),
                "covers" => $this->getParameter('covers_directory'),
                "books" => $this->getParameter('books_directory'),
            )
        ));
    }

    /**
     * @Route("/add", name="book_add")
     */
    public function bookAddAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice-success', 'Книга "'.$book->getName().'" была успешно добавлена');

            return $this->redirect($this->generateUrl('book_list'));
        }

        return $this->render('Books/add_book.html.twig',array(
            "books" => null,
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/{bookId}/edit", name="book_edit")
     */
    public  function bookEditAction(Request $request, $bookId)
    {
        $repository = $this->getDoctrine()->getRepository("BookLibraryBundle:Book");
        $book = $repository->findOneBy(array("id" => $bookId));

        if(!$book){
            throw $this->createNotFoundException('Book not found');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice-success', 'Книга под номером "'.$book->getId().'" была успешно изменена');

            return $this->redirect($this->generateUrl('book_list'));
        }

        return $this->render('Books/edit_book.html.twig', array(
            "books" => $book,
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/{bookId}/remove", name="book_remove")
     */
    public function bookRemoveAction(Request $request, $bookId)
    {
        $repository = $this->getDoctrine()->getRepository("BookLibraryBundle:Book");
        $book = $repository->findOneBy(array("id" => $bookId));

        if(!$book){
            throw $this->createNotFoundException('Book not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice-success', 'Книга под номером "'.$bookId.'" была удалена');
        return $this->redirect($this->generateUrl('book_list'));
    }
}
