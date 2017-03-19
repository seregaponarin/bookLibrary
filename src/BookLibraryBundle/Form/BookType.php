<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 08.02.2017
 * Time: 17:33
 */

namespace BookLibraryBundle\Form;


use BookLibraryBundle\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, array("label" => "Название книги"))
            ->add('author', TextType::class, array("label" => "Автор книги"))
            ->add('cover_path', FileType::class, array('label' => "Обложка книги", "data_class" => null, "required" => false,
                'constraints' => array(
                    new File(array(
                        'maxSize' => '2M',
                        'mimeTypes' => array('image/png', 'image/jpeg'),
                        'mimeTypesMessage' => 'Неверный формат файла (только png/jpg)',
                        'maxSizeMessage' => 'Слишком большой файл (max: 2Мб)',
                    ))
                )
            ))
            ->add('file_path', FileType::class, array('label' => "Файл книги", "data_class" => null, "required" => false,
                'constraints' => array(
                    new File(array(
                        'maxSize' => '5M',
                        'maxSizeMessage' => 'Слишком большой файл (max: 5Мб)',
                    ))
                )
            ))
            ->add('readed_date', DateType::class, array("widget" => "single_text", "label" => "Дата прочтения"))
            ->add('allow_download', CheckboxType::class, array("label" => "Разрешить скачивание", "required" => false))
            ->add("save", SubmitType::class, array("label" => "Создать/Сохранить"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Book::class
        ));
    }
}