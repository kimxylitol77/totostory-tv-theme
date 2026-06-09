# Cloudways GitHub 자동 배포 설정

이 테마 폴더를 GitHub 저장소로 올리면, `main` 브랜치에 push할 때마다 Cloudways 워드프레스 테마 폴더로 자동 배포됩니다.

## 1. Cloudways에서 SSH 접속 준비

Cloudways 관리자에서 해당 워드프레스 앱으로 이동합니다.

1. `Applications`에서 토토스토리 워드프레스 앱 선택
2. `Access Details`에서 앱의 Public IP/Host, Application Username 확인
3. `Application Settings`에서 SSH Access 활성화
4. 가능하면 Master Credentials보다 Application Credentials 사용

Application Credentials는 해당 앱에만 접근하므로 운영 서버 전체 권한을 노출하지 않아 더 안전합니다.

## 2. 배포용 SSH 키 만들기

Mac 터미널에서 실행합니다.

```bash
ssh-keygen -t ed25519 -C "github-actions-totostory-cloudways" -f ~/.ssh/totostory_cloudways
```

생성된 공개키를 Cloudways SSH Public Key/Authorized Keys에 등록합니다.

```bash
cat ~/.ssh/totostory_cloudways.pub
```

개인키는 GitHub Secret에만 넣고, 채팅이나 문서에 공유하지 마세요.

```bash
cat ~/.ssh/totostory_cloudways
```

## 3. Cloudways 경로 확인

Cloudways SSH로 접속해서 현재 경로를 확인합니다.

```bash
pwd
```

Application Credentials로 접속하면 보통 워드프레스 앱의 `public_html` 근처로 들어갑니다. 최종 배포 경로는 절대경로 또는 로그인 위치 기준 상대경로로 넣을 수 있지만, 반드시 아래처럼 테마 폴더까지 포함해야 합니다.

```text
/.../public_html/wp-content/themes/totostory-tv-theme
```

예시:

```text
/public_html/wp-content/themes/totostory-tv-theme
```

또는:

```text
/home/exampleapp/public_html/wp-content/themes/totostory-tv-theme
```

또는 Master Credentials를 쓰는 경우:

```text
/home/master/applications/APP_NAME/public_html/wp-content/themes/totostory-tv-theme
```

## 4. GitHub 저장소 만들기

GitHub에서 새 저장소를 만듭니다.

추천 이름:

```text
totostory-tv-theme
```

이 폴더에서 아래 명령을 실행합니다.

```bash
cd /Users/kimss/Documents/Codex/2026-06-09/sites-plugin-sites-openai-bundled-create/outputs/totostory-tv-theme
git init
git branch -M main
git add .
git commit -m "Initial TotoStory TV theme"
git remote add origin git@github.com:YOUR_ACCOUNT/totostory-tv-theme.git
git push -u origin main
```

## 5. GitHub Secrets 추가

GitHub 저장소에서 `Settings > Secrets and variables > Actions > New repository secret`으로 아래 값을 추가합니다.

```text
CLOUDWAYS_HOST
```

Cloudways 앱의 Public IP 또는 SSH Host입니다.

```text
CLOUDWAYS_USERNAME
```

Cloudways Application Username입니다.

```text
CLOUDWAYS_SSH_KEY
```

`~/.ssh/totostory_cloudways` 개인키 전체 내용입니다.

```text
CLOUDWAYS_PATH
```

워드프레스 테마 배포 경로입니다. 반드시 `wp-content/themes/totostory-tv-theme`로 끝나야 합니다.

```text
CLOUDWAYS_PORT
```

보통 `22`입니다. 비워도 워크플로에서 22를 사용합니다.

## 6. 배포 확인

GitHub 저장소에서 `Actions > Deploy theme to Cloudways`를 열어 실행 상태를 확인합니다.

성공하면 워드프레스 관리자에서:

1. `외모 > 테마`에서 `TotoStory TV` 활성화
2. `외모 > 메뉴`에서 기존 메뉴를 `Primary Menu`에 배정
3. `설정 > 고유주소`에서 저장

이후에는 테마 파일을 수정하고 GitHub에 push하면 Cloudways에 자동 반영됩니다.
