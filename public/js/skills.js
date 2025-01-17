document.addEventListener('DOMContentLoaded', () => {
    const skillInput = document.getElementById('skill_input');
    const skillSuggestions = document.getElementById('skill_suggestions');
    const selectedSkills = document.getElementById('selected_skills');
    const skillsInput = document.getElementById('skills_input');

    skillInput.addEventListener('input', function () {
        const query = this.value;
        const categoryId = document.getElementById('category').value;

        if (query.length > 0) {
            fetch(`/api/skills?query=${query}&category_id=${categoryId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Failed to fetch skills");
                    return response.json();
                })
                .then(data => {
                    skillSuggestions.innerHTML = data.map(skill => `<div class="skill-suggestion">${skill.name}</div>`).join('');
                })
                .catch(error => {
                    console.error('Error fetching skills:', error);
                });
        } else {
            skillSuggestions.innerHTML = '';
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('skill-suggestion')) {
            const skill = e.target.textContent;
            const skillTag = `<span class="tag">${skill} <span class="remove-tag">&times;</span></span>`;

            selectedSkills.innerHTML += skillTag;

            const currentSkills = skillsInput.value ? skillsInput.value.split(',') : [];
            currentSkills.push(skill);
            skillsInput.value = currentSkills.join(',');

            skillInput.value = '';
            skillSuggestions.innerHTML = '';
        }
    });

    selectedSkills.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tag')) {
            const tag = e.target.parentElement;
            const skill = tag.textContent.trim().slice(0, -1);

            const currentSkills = skillsInput.value.split(',').filter(s => s !== skill);
            skillsInput.value = currentSkills.join(',');

            tag.remove();
        }
    });
});
