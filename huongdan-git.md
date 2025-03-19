cd /root/.ssh
ssh-keygen -t rsa
chon: id_rsa
enter 2 lan -> server tao ra 2 files: id_rsa (client)  id_rsa.pub (server)
cat id_rsa.pub ->copy nội dung
đăng nhập vào github: 
sau đó: https://github.com/settings/keys
chọn New SSH key
+ Nhập Tilte
+ >copy nội dung id_rsa.pub vào key
+ Add SSH Key


---Lưu ý sử dụng các lệnh git
+ trường hợp git pull từ server github. Để tự động ghi đè khi thực hiện lệnh git pull
làm việc với nhánh main
git checkout main
git fetch --all
git reset --hard origin/main

+ Để ghi đè lên server GitHub khi thực hiện git push, bạn có thể sử dụng tùy chọn --force. Dưới đây là các bước thực hiện:
git checkout main
git add .
git commit -m "Your commit message"
git push --force origin main

 +Liệt kê các commit
git log --oneline
+Phục hồi lại commit
git reset --hard <commit-hash> (commit-hash là các mã số: dbd59da)