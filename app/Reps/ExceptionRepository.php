<?php


namespace App\Reps;


class ExceptionRepository
{
    public const TASK_NOT_FOUND = 'Задача с таким id не существует';
    public const TASKS_NOT_FOUND = 'Задач не найдено';
    public const TASK_WITH_ID_NOT_EXIST = 'Задача с таким id не существует';
    public const TASK_DEADLINE_SET_IN_PAST = 'Срок выполнения задачи указан в прошлом';
    public const TASK_ID_IS_NULL= 'Не указан id задачи';
    public const TASK_FIELD_NOT_FOUND = 'Указано неверное поле %s';
    public const TASK_STATUS_IS_NULL = 'Поле status не указано';
    public const TASK_DEADLINE_IS_NULL = 'Поле deadline не указано';
}
