<?php
require 'connect_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'post') {
        $title = $_POST['post_title'];
        $content = $_POST['post_content'];
        $image = $_FILES['post_image']['name'];
        $target = 'uploads/' . basename($image);

        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $target)) {
            $stmt = $pdo->prepare('INSERT INTO posts (title, content, image) VALUES (?, ?, ?)');
            $stmt->execute([$title, $content, $image]);
            echo "Post added successfully!";
        } else {
            echo "Failed to upload image.";
        }
    } elseif ($type === 'vacancy') {
        $title = $_POST['vacancy_title'];
        $salary = $_POST['vacancy_salary'];
        $content = $_POST['vacancy_content'];

        $stmt = $pdo->prepare('INSERT INTO vacancies (title, salary, content) VALUES (?, ?, ?)');
        $stmt->execute([$title, $salary, $content]);
        echo "Vacancy added successfully!";
    } elseif ($type === 'partner') {
        $title = $_POST['partner_title'];
        $content = $_POST['partner_content'];
        $image = $_FILES['partner_image']['name'];
        $target = 'uploads/' . basename($image);

        if (move_uploaded_file($_FILES['partner_image']['tmp_name'], $target)) {
            $stmt = $pdo->prepare('INSERT INTO partners (title, content, image) VALUES (?, ?, ?)');
            $stmt->execute([$title, $content, $image]);
            echo "Partner added successfully!";
        } else {
            echo "Failed to upload image.";
        }
    }
}

$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll();

$stmt = $pdo->query('SELECT * FROM vacancies ORDER BY title DESC');
$vacancies = $stmt->fetchAll();

$stmt = $pdo->query('SELECT * FROM partners ORDER BY title DESC');
$partners = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>CMS СМ-Строй</title>
    <link rel="icon" class="icon" href="../img/cms_icon.png" type="image/x-icon">

    <link rel="stylesheet" href="../css/reset.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container pt-4">
        <header class="pb-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                <svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="45" rx="10" fill="#DC3545"/>
                    <path d="M15.032 24.288C13.736 24.288 12.528 24.08 11.408 23.664C10.304 23.232 9.344 22.624 8.528 21.84C7.712 21.056 7.072 20.136 6.608 19.08C6.16 18.024 5.936 16.864 5.936 15.6C5.936 14.336 6.16 13.176 6.608 12.12C7.072 11.064 7.712 10.144 8.528 9.36C9.36 8.576 10.328 7.976 11.432 7.56C12.536 7.128 13.744 6.912 15.056 6.912C16.512 6.912 17.824 7.168 18.992 7.68C20.176 8.176 21.168 8.912 21.968 9.888L19.472 12.192C18.896 11.536 18.256 11.048 17.552 10.728C16.848 10.392 16.08 10.224 15.248 10.224C14.464 10.224 13.744 10.352 13.088 10.608C12.432 10.864 11.864 11.232 11.384 11.712C10.904 12.192 10.528 12.76 10.256 13.416C10 14.072 9.872 14.8 9.872 15.6C9.872 16.4 10 17.128 10.256 17.784C10.528 18.44 10.904 19.008 11.384 19.488C11.864 19.968 12.432 20.336 13.088 20.592C13.744 20.848 14.464 20.976 15.248 20.976C16.08 20.976 16.848 20.816 17.552 20.496C18.256 20.16 18.896 19.656 19.472 18.984L21.968 21.288C21.168 22.264 20.176 23.008 18.992 23.52C17.824 24.032 16.504 24.288 15.032 24.288ZM24.5021 24V7.2H27.7181L34.8701 19.056H33.1661L40.1981 7.2H43.4141L43.4381 24H39.7901L39.7661 12.792H40.4621L34.8221 22.224H33.0941L27.3341 12.792H28.1501V24H24.5021Z" fill="white"/>
                    <path d="M10.852 36.06C10.228 36.06 9.668 35.924 9.172 35.652C8.684 35.372 8.3 34.992 8.02 34.512C7.74 34.024 7.6 33.468 7.6 32.844C7.6 32.212 7.74 31.656 8.02 31.176C8.3 30.696 8.684 30.32 9.172 30.048C9.668 29.776 10.228 29.64 10.852 29.64C11.388 29.64 11.872 29.744 12.304 29.952C12.736 30.16 13.076 30.472 13.324 30.888L12.688 31.32C12.472 31 12.204 30.764 11.884 30.612C11.564 30.46 11.216 30.384 10.84 30.384C10.392 30.384 9.988 30.488 9.628 30.696C9.268 30.896 8.984 31.18 8.776 31.548C8.568 31.916 8.464 32.348 8.464 32.844C8.464 33.34 8.568 33.772 8.776 34.14C8.984 34.508 9.268 34.796 9.628 35.004C9.988 35.204 10.392 35.304 10.84 35.304C11.216 35.304 11.564 35.228 11.884 35.076C12.204 34.924 12.472 34.692 12.688 34.38L13.324 34.812C13.076 35.22 12.736 35.532 12.304 35.748C11.872 35.956 11.388 36.06 10.852 36.06ZM16.0565 36V30.216L16.2725 30.444H13.6685V29.7H19.2965V30.444H16.6925L16.9085 30.216V36H16.0565ZM23.7804 36.06C23.2364 36.06 22.7444 35.936 22.3044 35.688C21.8644 35.432 21.5124 35.068 21.2484 34.596C20.9924 34.116 20.8644 33.532 20.8644 32.844C20.8644 32.156 20.9924 31.576 21.2484 31.104C21.5044 30.624 21.8524 30.26 22.2924 30.012C22.7324 29.764 23.2284 29.64 23.7804 29.64C24.3804 29.64 24.9164 29.776 25.3884 30.048C25.8684 30.312 26.2444 30.688 26.5164 31.176C26.7884 31.656 26.9244 32.212 26.9244 32.844C26.9244 33.484 26.7884 34.044 26.5164 34.524C26.2444 35.004 25.8684 35.38 25.3884 35.652C24.9164 35.924 24.3804 36.06 23.7804 36.06ZM20.5284 38.328V29.7H21.3444V31.596L21.2604 32.856L21.3804 34.128V38.328H20.5284ZM23.7204 35.304C24.1684 35.304 24.5684 35.204 24.9204 35.004C25.2724 34.796 25.5524 34.508 25.7604 34.14C25.9684 33.764 26.0724 33.332 26.0724 32.844C26.0724 32.356 25.9684 31.928 25.7604 31.56C25.5524 31.192 25.2724 30.904 24.9204 30.696C24.5684 30.488 24.1684 30.384 23.7204 30.384C23.2724 30.384 22.8684 30.488 22.5084 30.696C22.1564 30.904 21.8764 31.192 21.6684 31.56C21.4684 31.928 21.3684 32.356 21.3684 32.844C21.3684 33.332 21.4684 33.764 21.6684 34.14C21.8764 34.508 22.1564 34.796 22.5084 35.004C22.8684 35.204 23.2724 35.304 23.7204 35.304ZM31.347 36.06C30.739 36.06 30.191 35.924 29.703 35.652C29.223 35.372 28.843 34.992 28.563 34.512C28.283 34.024 28.143 33.468 28.143 32.844C28.143 32.212 28.283 31.656 28.563 31.176C28.843 30.696 29.223 30.32 29.703 30.048C30.183 29.776 30.731 29.64 31.347 29.64C31.971 29.64 32.523 29.776 33.003 30.048C33.491 30.32 33.871 30.696 34.143 31.176C34.423 31.656 34.563 32.212 34.563 32.844C34.563 33.468 34.423 34.024 34.143 34.512C33.871 34.992 33.491 35.372 33.003 35.652C32.515 35.924 31.963 36.06 31.347 36.06ZM31.347 35.304C31.803 35.304 32.207 35.204 32.559 35.004C32.911 34.796 33.187 34.508 33.387 34.14C33.595 33.764 33.699 33.332 33.699 32.844C33.699 32.348 33.595 31.916 33.387 31.548C33.187 31.18 32.911 30.896 32.559 30.696C32.207 30.488 31.807 30.384 31.359 30.384C30.911 30.384 30.511 30.488 30.159 30.696C29.807 30.896 29.527 31.18 29.319 31.548C29.111 31.916 29.007 32.348 29.007 32.844C29.007 33.332 29.111 33.764 29.319 34.14C29.527 34.508 29.807 34.796 30.159 35.004C30.511 35.204 30.907 35.304 31.347 35.304ZM36.3839 36V29.7H37.2359V34.704L41.4479 29.7H42.2039V36H41.3519V30.984L37.1519 36H36.3839ZM39.2399 28.788C38.7119 28.788 38.2839 28.656 37.9559 28.392C37.6359 28.12 37.4679 27.732 37.4519 27.228H38.0639C38.0719 27.548 38.1839 27.8 38.3999 27.984C38.6159 28.168 38.8959 28.26 39.2399 28.26C39.5839 28.26 39.8639 28.168 40.0799 27.984C40.3039 27.8 40.4199 27.548 40.4279 27.228H41.0399C41.0319 27.732 40.8639 28.12 40.5359 28.392C40.2079 28.656 39.7759 28.788 39.2399 28.788Z" fill="white"/>
                </svg>
            </a>
        </header>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <form class="p-4 rounded-3 bg-body-tertiary" action="add.php" method="post" enctype="multipart/form-data">
                    <legend>Добавить новость</legend>
                    <input type="hidden" name="type" value="post">
                    <div class="mb-3">
                        <label class="form-label" for="post_title">Заголовок:</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="post_content">Текст:</label>
                        <textarea id="post_content" class="form-control" name="post_content" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="post_image">Картинка:</label>
                        <input type="file" class="form-control" id="post_image" name="post_image" required>
                    </div>
                    <input type="submit" class="btn btn-danger" value="Добавить">
                </form>
            </div>
            
            <div class="col-lg-4 mb-4">
                <form class="p-4 rounded-3 bg-body-tertiary" action="add.php" method="post">
                    <legend>Добавить вакансию</legend>
                    <input type="hidden" name="type" value="vacancy">
                    <div class="mb-3">
                        <label class="form-label" for="vacancy_title">Название:</label>
                        <input type="text" class="form-control" id="vacancy_title" name="vacancy_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="vacancy_salary">Зарплата:</label>
                        <input type="text" class="form-control" id="vacancy_salary" name="vacancy_salary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="vacancy_content">Описание:</label>
                        <textarea class="form-control" id="vacancy_content" name="vacancy_content" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-danger" value="Добавить">
                </form>
            </div>
                
            <div class="col-lg-4 mb-4">
                <form class="p-4 rounded-3 bg-body-tertiary" action="add.php" method="post" enctype="multipart/form-data">
                    <legend>Добавить партнера</legend>
                    <input type="hidden" name="type" value="partner">
                    <div class="mb-3">
                        <label class="form-label" for="partner_title">Название:</label>
                        <input type="text" class="form-control" id="partner_title" name="partner_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="partner_content">Описание:</label>
                        <textarea class="form-control" id="partner_content" name="partner_content" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="partner_image">Картинка:</label>
                        <input type="file" class="form-control" id="partner_image" name="partner_image" required>
                    </div>
                    <input type="submit" class="btn btn-danger" value="Добавить">
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>Все новости:</h1>
        <?php foreach ($posts as $post): ?>
            <div class="card bg-body-tertiary border-0 mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php if ($post['image']): ?>
                            <img class="img-fluid rounded-start object-fit-fill" src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <p class="card-text">Дата публикации: <?php echo $post['created_at']; ?></p>
                            <a class="card-link" href="edit_post.php?id=<?php echo $post['id']; ?>">Редактировать</a>
                            <a class="card-link" href="delete_post.php?id=<?php echo $post['id']; ?>">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <h1>Все вакансии:</h1>
        <?php foreach ($vacancies as $vacancy): ?>
            <div class="card bg-body-tertiary border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($vacancy['title']); ?></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo htmlspecialchars($vacancy['salary']); ?></h6>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($vacancy['content'])); ?></p>
                    <a class="card-link" href="edit_vacancy.php?id=<?php echo $vacancy['id']; ?>">Редактировать</a>
                    <a class="card-link" href="delete_vacancy.php?id=<?php echo $vacancy['id']; ?>">Удалить</a>
                </div>
            </div>
        <?php endforeach; ?>

        <h1>Все партнеры:</h1>

        <?php for($i = 0; $i < count($partners); $i++): ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card h-100 bg-body-tertiary border-0">
                        <?php if ($partners[$i]['image']): ?>
                            <img class="card-img-top" src="uploads/<?php echo htmlspecialchars($partners[$i]['image']); ?>" alt="<?php echo htmlspecialchars($partners[$i]['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($partners[$i]['title']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($partners[$i]['content'])); ?></p>
                            <a class="card-link" href="edit_partner.php?id=<?php echo $partners[$i]['id']; ?>">Редактировать</a>
                            <a class="card-link" href="delete_partner.php?id=<?php echo $partners[$i]['id']; ?>">Удалить</a>
                        </div>
                    </div>
                </div>
                <?php $i++ ?>
                <?php if($i >= count($partners)): break; endif; ?>
                <div class="col-md-6 mb-3">
                    <div class="card h-100 bg-body-tertiary border-0">
                        <?php if ($partners[$i]['image']): ?>
                            <img class="card-img-top" src="uploads/<?php echo htmlspecialchars($partners[$i]['image']); ?>" alt="<?php echo htmlspecialchars($partners[$i]['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($partners[$i]['title']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($partners[$i]['content'])); ?></p>
                            <a class="card-link" href="edit_partner.php?id=<?php echo $partners[$i]['id']; ?>">Редактировать</a>
                            <a class="card-link" href="delete_partner.php?id=<?php echo $partners[$i]['id']; ?>">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">© 2024 СМ-Строй, Inc</p>

        <a href="#top" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="50" height="45" rx="10" fill="#DC3545"/>
                <path d="M15.032 24.288C13.736 24.288 12.528 24.08 11.408 23.664C10.304 23.232 9.344 22.624 8.528 21.84C7.712 21.056 7.072 20.136 6.608 19.08C6.16 18.024 5.936 16.864 5.936 15.6C5.936 14.336 6.16 13.176 6.608 12.12C7.072 11.064 7.712 10.144 8.528 9.36C9.36 8.576 10.328 7.976 11.432 7.56C12.536 7.128 13.744 6.912 15.056 6.912C16.512 6.912 17.824 7.168 18.992 7.68C20.176 8.176 21.168 8.912 21.968 9.888L19.472 12.192C18.896 11.536 18.256 11.048 17.552 10.728C16.848 10.392 16.08 10.224 15.248 10.224C14.464 10.224 13.744 10.352 13.088 10.608C12.432 10.864 11.864 11.232 11.384 11.712C10.904 12.192 10.528 12.76 10.256 13.416C10 14.072 9.872 14.8 9.872 15.6C9.872 16.4 10 17.128 10.256 17.784C10.528 18.44 10.904 19.008 11.384 19.488C11.864 19.968 12.432 20.336 13.088 20.592C13.744 20.848 14.464 20.976 15.248 20.976C16.08 20.976 16.848 20.816 17.552 20.496C18.256 20.16 18.896 19.656 19.472 18.984L21.968 21.288C21.168 22.264 20.176 23.008 18.992 23.52C17.824 24.032 16.504 24.288 15.032 24.288ZM24.5021 24V7.2H27.7181L34.8701 19.056H33.1661L40.1981 7.2H43.4141L43.4381 24H39.7901L39.7661 12.792H40.4621L34.8221 22.224H33.0941L27.3341 12.792H28.1501V24H24.5021Z" fill="white"/>
                <path d="M10.852 36.06C10.228 36.06 9.668 35.924 9.172 35.652C8.684 35.372 8.3 34.992 8.02 34.512C7.74 34.024 7.6 33.468 7.6 32.844C7.6 32.212 7.74 31.656 8.02 31.176C8.3 30.696 8.684 30.32 9.172 30.048C9.668 29.776 10.228 29.64 10.852 29.64C11.388 29.64 11.872 29.744 12.304 29.952C12.736 30.16 13.076 30.472 13.324 30.888L12.688 31.32C12.472 31 12.204 30.764 11.884 30.612C11.564 30.46 11.216 30.384 10.84 30.384C10.392 30.384 9.988 30.488 9.628 30.696C9.268 30.896 8.984 31.18 8.776 31.548C8.568 31.916 8.464 32.348 8.464 32.844C8.464 33.34 8.568 33.772 8.776 34.14C8.984 34.508 9.268 34.796 9.628 35.004C9.988 35.204 10.392 35.304 10.84 35.304C11.216 35.304 11.564 35.228 11.884 35.076C12.204 34.924 12.472 34.692 12.688 34.38L13.324 34.812C13.076 35.22 12.736 35.532 12.304 35.748C11.872 35.956 11.388 36.06 10.852 36.06ZM16.0565 36V30.216L16.2725 30.444H13.6685V29.7H19.2965V30.444H16.6925L16.9085 30.216V36H16.0565ZM23.7804 36.06C23.2364 36.06 22.7444 35.936 22.3044 35.688C21.8644 35.432 21.5124 35.068 21.2484 34.596C20.9924 34.116 20.8644 33.532 20.8644 32.844C20.8644 32.156 20.9924 31.576 21.2484 31.104C21.5044 30.624 21.8524 30.26 22.2924 30.012C22.7324 29.764 23.2284 29.64 23.7804 29.64C24.3804 29.64 24.9164 29.776 25.3884 30.048C25.8684 30.312 26.2444 30.688 26.5164 31.176C26.7884 31.656 26.9244 32.212 26.9244 32.844C26.9244 33.484 26.7884 34.044 26.5164 34.524C26.2444 35.004 25.8684 35.38 25.3884 35.652C24.9164 35.924 24.3804 36.06 23.7804 36.06ZM20.5284 38.328V29.7H21.3444V31.596L21.2604 32.856L21.3804 34.128V38.328H20.5284ZM23.7204 35.304C24.1684 35.304 24.5684 35.204 24.9204 35.004C25.2724 34.796 25.5524 34.508 25.7604 34.14C25.9684 33.764 26.0724 33.332 26.0724 32.844C26.0724 32.356 25.9684 31.928 25.7604 31.56C25.5524 31.192 25.2724 30.904 24.9204 30.696C24.5684 30.488 24.1684 30.384 23.7204 30.384C23.2724 30.384 22.8684 30.488 22.5084 30.696C22.1564 30.904 21.8764 31.192 21.6684 31.56C21.4684 31.928 21.3684 32.356 21.3684 32.844C21.3684 33.332 21.4684 33.764 21.6684 34.14C21.8764 34.508 22.1564 34.796 22.5084 35.004C22.8684 35.204 23.2724 35.304 23.7204 35.304ZM31.347 36.06C30.739 36.06 30.191 35.924 29.703 35.652C29.223 35.372 28.843 34.992 28.563 34.512C28.283 34.024 28.143 33.468 28.143 32.844C28.143 32.212 28.283 31.656 28.563 31.176C28.843 30.696 29.223 30.32 29.703 30.048C30.183 29.776 30.731 29.64 31.347 29.64C31.971 29.64 32.523 29.776 33.003 30.048C33.491 30.32 33.871 30.696 34.143 31.176C34.423 31.656 34.563 32.212 34.563 32.844C34.563 33.468 34.423 34.024 34.143 34.512C33.871 34.992 33.491 35.372 33.003 35.652C32.515 35.924 31.963 36.06 31.347 36.06ZM31.347 35.304C31.803 35.304 32.207 35.204 32.559 35.004C32.911 34.796 33.187 34.508 33.387 34.14C33.595 33.764 33.699 33.332 33.699 32.844C33.699 32.348 33.595 31.916 33.387 31.548C33.187 31.18 32.911 30.896 32.559 30.696C32.207 30.488 31.807 30.384 31.359 30.384C30.911 30.384 30.511 30.488 30.159 30.696C29.807 30.896 29.527 31.18 29.319 31.548C29.111 31.916 29.007 32.348 29.007 32.844C29.007 33.332 29.111 33.764 29.319 34.14C29.527 34.508 29.807 34.796 30.159 35.004C30.511 35.204 30.907 35.304 31.347 35.304ZM36.3839 36V29.7H37.2359V34.704L41.4479 29.7H42.2039V36H41.3519V30.984L37.1519 36H36.3839ZM39.2399 28.788C38.7119 28.788 38.2839 28.656 37.9559 28.392C37.6359 28.12 37.4679 27.732 37.4519 27.228H38.0639C38.0719 27.548 38.1839 27.8 38.3999 27.984C38.6159 28.168 38.8959 28.26 39.2399 28.26C39.5839 28.26 39.8639 28.168 40.0799 27.984C40.3039 27.8 40.4199 27.548 40.4279 27.228H41.0399C41.0319 27.732 40.8639 28.12 40.5359 28.392C40.2079 28.656 39.7759 28.788 39.2399 28.788Z" fill="white"/>
            </svg>
        </a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>