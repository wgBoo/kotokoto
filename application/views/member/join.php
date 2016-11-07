<section id="join">
    <div>
        <h1>회원가입</h1>
        <form name="join" action="/Member/joinDB" method="post">
            <p>
                아이디 <input type="text" name="uid" value="">
                <input type="button" value="중복확인">
            </p>
            <p>비밀번호 <input type="password" name="upwd" value=""></p>
            <p>비밀번호 확인 <input type="password" name="upwdc"></p>
            <p>이메일 <input type="email" name="email"></p>
            <p>
                나이대
                <select name="old">
                    <option>10대</option>
                    <option>20대</option>
                    <option>30대</option>
                    <option>40대</option>
                    <option>50대</option>
                </select>
            </p>
            <p>관심사</p>
            <p>
                <input type="submit" value="가입" name="submit_join">
                <input type="button" value="취소" onclick="location.href='/Member/index'">
            </p>
        </form>
    </div>
</section>